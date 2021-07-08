<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Models\Product\ProductPost;
use App\Http\Controllers\Controller;
use App\Models\Product\PurchasePost;
use App\Models\Product\ProductPostDetail;
use App\Models\Product\PurchasePostDetail;
use Laratrust, Lang, DB, Exception, Auth, DataTables;

class StorageTransactionController extends Controller
{
    public function index()
    {
        if (!Laratrust::isAbleTo('view-storage-transaction')) return abort(404);

        return view('storage-transaction.index');
    }

    public function data()
    {
        if (!Laratrust::isAbleTo('view-storage-transaction')) return abort(404);

        $productPosts = ProductPost::select('product_posts.id', 'product_posts.type', 'product_posts.created_at', 'users.name AS user_name')->leftJoin('users', 'users.id', '=', 'product_posts.posted_by');

        return DataTables::of($productPosts)
            ->editColumn('type', function($productPost) {
                $color = $productPost->type == 'New' ? 'primary' : 'secondary';

                return '<span class="badge badge-' . $color . '">' . Lang::get($productPost->type) . '</span>';
            })
            ->addColumn('action', function($productPost) {
                return '<a href="' . route('storage-transaction.show', $productPost->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('View') . '"><i class="la la-eye"></i></a>';
            })
            ->rawColumns(['action', 'type'])
            ->make(true);
    }

    public function create()
    {
        if (!Laratrust::isAbleTo('create-storage-transaction')) return abort(404);

        return view('storage-transaction.create');
    }

    public function store(Request $request)
    {
        if (!Laratrust::isAbleTo('create-storage-transaction')) return abort(404);

        $rules = [
            'jenis' => 'required|in:New',
        ];
        if ($request->jenis == 'New') {
            $rules = array_merge($rules, [
                'nomor_pembelian' => 'required|integer',
            ]);
        }
        $this->validate($request, $rules);

        if ($request->jenis == 'New') {
            $purchase = PurchasePost::whereIn('status', ['Returned', 'Incomplete', 'Completed'])
                            ->find($request->nomor_pembelian);
            if (!$purchase) return $this->validationError(Lang::get('Purchase not found.'));

            $purchaseDetails = PurchasePostDetail::select('purchase_post_details.*', 'products.mac_address AS product_mac_address', 'products.code AS product_code')
                    ->leftJoin('products', 'products.id', '=', 'purchase_post_details.product_id')
                    ->where('purchase_post_details.purchase_post_id', $purchase->id)
                    ->lockForUpdate()
                    ->get();
            $totalQuantity = 0;
            foreach ($purchaseDetails as $purchaseDetail) {
                $quantity = json_decode($purchaseDetail->quantity);
                $totalUnstoraged = $quantity->validated - $quantity->storaged;
                $totalQuantity += $totalUnstoraged;

                if ($purchaseDetail->product_mac_address) {
                    $rules = [];
                    for ($i = 0; $i < $totalUnstoraged; $i++) {
                        $rules = array_merge($rules, [
                            'alamat_mac.'.$purchaseDetail->product_id.'.'.$i => 'required|string|size:17|unique:product_post_details,mac_address'
                        ]);
                    }
                    $this->validate($request, $rules);
                }
            }

            if ($totalQuantity < 1) return $this->validationError(Lang::get('Purchase not found.'));

            DB::beginTransaction();
            try {
                $productPost = new ProductPost;
                $productPost->purchase_post_id = $purchase->id;
                $productPost->type = 'New';
                $productPost->posted_by = Auth::user()->id;
                $productPost->save();

                foreach ($purchaseDetails as $purchaseDetail) {
                    $quantity = json_decode($purchaseDetail->quantity);
                    $totalUnstoraged = $quantity->validated - $quantity->storaged;

                    $latestProductPostDetail = ProductPostDetail::select('product_post_details.sku')
                        ->leftJoin('product_posts', 'product_posts.id', '=', 'product_post_details.product_post_id')
                        ->where('product_posts.type', 'New')
                        ->where('product_post_details.product_id', $purchaseDetail->product_id)
                        ->orderBy('product_post_details.id', 'desc')
                        ->first();

                    $product = Product::whereId($purchaseDetail->product_id)->lockForUpdate()->first();
                    if (!$product)
                        return $this->validationError(Lang::get('Product') . ' #' . $purchaseDetail->product_id . ' ' . Lang::get('not found.'));

                    $stock = json_decode($product->stock);

                    for ($i = 0; $i < $totalUnstoraged; $i++) {
                        $index = $latestProductPostDetail && $product->sku_per_unit
                            ? ((int) explode($purchaseDetail->product_code . '-', $latestProductPostDetail->sku)[1]) + $i + 1
                            : ($latestProductPostDetail && !$product->sku_per_unit
                                ? ((int) explode($purchaseDetail->product_code . '-', $latestProductPostDetail->sku)[1]) + 1
                                : (!$latestProductPostDetail && $product->sku_per_unit
                                    ? $i + 1
                                    : 1));

                        $productPostDetail = new ProductPostDetail;
                        $productPostDetail->product_post_id = $productPost->id;
                        $productPostDetail->product_id = $purchaseDetail->product_id;
                        $productPostDetail->sku = $purchaseDetail->product_code . '-' . $index;
                        $productPostDetail->mac_address = $product->mac_address
                                                            ? $request->alamat_mac[$product->id][$i]
                                                            : null;
                        $productPostDetail->quantity = 1;
                        $productPostDetail->last_stock = $stock->new + $i;
                        $productPostDetail->save();
                    }

                    $purchaseDetail->quantity = json_encode([
                        'ordered' => $quantity->ordered,
                        'validated' => $quantity->validated,
                        'storaged' => $quantity->storaged + $totalUnstoraged
                    ]);
                    $purchaseDetail->save();

                    $product->stock = json_encode([
                        'new' => $stock->new + $totalUnstoraged,
                        'secondhand' => $stock->secondhand,
                        'damaged' => $stock->damaged,
                        'lost' => $stock->lost
                    ]);
                    $product->save();
                }
            } catch (Exception $e) {
                DB::rollBack();
                report($e);
                return abort(500);
            }
            DB::commit();

            $message = Lang::get('Storage transaction number') . ' #' . $productPost->id . ' ' . Lang::get('successfully created.');
            return redirect()->route('storage-transaction.show', $productPost->id)->with('status', $message);
        }
    }

    public function show($id)
    {
        if (!Laratrust::isAbleTo('view-storage-transaction')) return abort(404);

        $productPost = ProductPost::select('product_posts.id', 'product_posts.purchase_post_id', 'product_posts.type', 'product_posts.created_at', 'users.name AS user_name')
                ->leftJoin('users', 'users.id', '=', 'product_posts.posted_by')
                ->findOrFail($id);

        if ($productPost->type == 'New') {
            $productPostDetails = ProductPostDetail::selectRaw('product_post_details.product_id, products.code AS product_code, products.name AS product_name, products.photo AS product_photo, products.sku_per_unit AS product_sku_per_unit, products.mac_address AS product_mac_address, COUNT(*) AS quantity')
                    ->leftJoin('products', 'products.id', '=', 'product_post_details.product_id')
                    ->where('product_post_details.product_post_id', $id)
                    ->groupBy('product_id', 'product_code', 'product_name', 'product_photo', 'product_sku_per_unit', 'product_mac_address')
                    ->get();
            $zProductPostDetails = ProductPostDetail::select('product_id', 'sku', 'mac_address')
                    ->where('product_post_details.product_post_id', $id)
                    ->groupBy('product_id', 'sku', 'mac_address')
                    ->get();
        }

        return view('storage-transaction.show', compact('productPost', 'productPostDetails', 'zProductPostDetails'));
    }
}
