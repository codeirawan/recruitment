<?php

namespace App\Http\Controllers\Product;

use App\User;
use Carbon\Carbon;
use App\Permission;
use Illuminate\Http\Request;
use App\Models\Product\Supplier;
use App\Http\Controllers\Controller;
use App\Models\Master\PaymentMethod;
use App\Models\Product\PurchasePost;
use App\Models\Master\ProductCategory;
use App\Models\Product\PurchasePostDetail;
use App\Models\Product\PurchasePostStatus;
use App\Models\Product\PurchasePostValidate;
use App\Notifications\Purchase\RejectPurchase;
use App\Notifications\Purchase\VerifyPurchase;
use App\Notifications\Purchase\ProcessPurchase;
use App\Notifications\Purchase\PostponePurchase;
use App\Notifications\Purchase\ValidatePurchase;
use App\Models\Product\PurchasePostValidateDetail;
use Laratrust, Lang, Auth, DB, Exception, DataTables;

class PurchaseController extends Controller
{
    public function index()
    {
        if (!Laratrust::isAbleTo('view-purchase')) return abort(404);

        return view('purchase.index');
    }

    public function data()
    {
        if (!Laratrust::isAbleTo('view-purchase')) return abort(404);

        $purchases = PurchasePost::select('purchase_posts.created_at', 'purchase_posts.id', 'purchase_posts.total_price', 'purchase_posts.status', 'suppliers.name AS supplier', 'master_payment_methods.name AS payment_method', 'purchase_posts.proof_of_payment')
                        ->leftJoin('suppliers', 'suppliers.id', '=', 'purchase_posts.supplier_id')
                        ->leftJoin('master_payment_methods', 'master_payment_methods.id', '=', 'purchase_posts.payment_method_id');

        return DataTables::of($purchases)
            ->editColumn('total_price', function($purchase) {
                return 'Rp' . number_format($purchase->total_price, 2);
            })
            ->editColumn('proof_of_payment', function($purchase) {
                return $purchase->proof_of_payment
                    ? '<i class="la la-check text-success font-weight-bold"></i>'
                    : '<i class="la la-times text-danger font-weight-bold"></i>';
            })
            ->editColumn('status', function($purchase) {
                $color = $purchase->status == 'Waiting for Approval' ? 'light'
                            : ($purchase->status == 'Voided' ? 'dark'
                                : ($purchase->status == 'Approved' ? 'success'
                                    : ($purchase->status == 'Postponed' || $purchase->status == 'Returned' ? 'warning'
                                        : ($purchase->status == 'Rejected' ? 'danger'
                                            : ($purchase->status == 'Processed' ? 'info'
                                                : ($purchase->status == 'Incomplete' ? 'secondary'
                                                    : 'primary'))))));

                return '<span class="badge badge-' . $color . '">' . Lang::get($purchase->status) . '</span>';
            })
            ->addColumn('action', function($purchase) {
                $view = '<a href="' . route('purchase.show', $purchase->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('View') . '"><i class="la la-eye"></i></a>';

                return (Laratrust::isAbleTo('view-purchase') ? $view : '');
            })
            ->rawColumns(['status', 'action', 'proof_of_payment'])
            ->make(true);
    }

    public function create()
    {
        if (!Laratrust::isAbleTo('create-purchase')) return abort(404);

        $suppliers = Supplier::select('id', 'name')->get();
        $paymentMethods = PaymentMethod::select('id', 'name')->get();

        return view('purchase.create', compact('suppliers', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        if (!Laratrust::isAbleTo('create-purchase')) return abort(404);

        $this->validate($request, [
            'pemasok' => ['required', 'integer', 'exists:suppliers,id,deleted_at,NULL'],
            'metode_pembayaran' => ['required', 'integer', 'exists:master_payment_methods,id,deleted_at,NULL'],
            'barang' => ['required'],
            'barang.*.id' => ['required', 'integer', 'exists:products,id,deleted_at,NULL'],
            'barang.*.harga' => ['required', 'numeric', 'min:0'],
            'barang.*.jumlah' => ['required', 'numeric', 'min:1'],
            'barang.*.catatan' => ['required', 'string', 'max:255'],
        ]);

        $totalPrice = 0;
        foreach ($request->barang as $i => $product) {
            $totalPrice += $product['harga'];

            if ($product['garansi']) {
                $this->validate($request, [
                    'barang.'.$i.'.tanggal_kedaluwarsa_garansi' => ['required', 'date_format:d-m-Y'],
                    'barang.'.$i.'.syarat_dan_ketentuan_garansi' => ['required'],
                ]);

                $warrantyExpirationDate = Carbon::parse($product['tanggal_kedaluwarsa_garansi']);
                if ($warrantyExpirationDate->lt(today()))
                    return $this->validationError(Lang::get('The warranty expiration date is invalid.'));
            }
        }

        DB::beginTransaction();
        try {
            $purchase = new PurchasePost;
            $purchase->total_price = $totalPrice;
            $purchase->supplier_id = $request->pemasok;
            $purchase->payment_method_id = $request->metode_pembayaran;
            $purchase->status = 'Waiting for Approval';
            $purchase->save();

            foreach ($request->barang as $product) {
                $purchaseDetail = new PurchasePostDetail;
                $purchaseDetail->purchase_post_id = $purchase->id;
                $purchaseDetail->product_id = $product['id'];
                $purchaseDetail->price = $product['harga'];
                $purchaseDetail->quantity = json_encode([
                    'ordered' => (int) $product['jumlah'],
                    'validated' => 0,
                    'storaged' => 0
                ]);
                $purchaseDetail->note = $product['catatan'];
                $purchaseDetail->is_guaranteed = $product['garansi'] ? 1 : 0;
                $purchaseDetail->warranty_expiration_date = $product['garansi'] ? $warrantyExpirationDate : null;
                $purchaseDetail->warranty_terms_and_conditions = $product['garansi'] ? $product['syarat_dan_ketentuan_garansi'] : null;
                $purchaseDetail->save();
            }

            $purchaseStatus = new PurchasePostStatus;
            $purchaseStatus->purchase_post_id = $purchase->id;
            $purchaseStatus->status = 'Submitted';
            $purchaseStatus->at = now();
            $purchaseStatus->by = Auth::user()->id;
            $purchaseStatus->note = $request->catatan;
            $purchaseStatus->save();
        } catch (Exception $e) {
            DB::rollBack();
            report($e);
            return abort(500);
        }
        DB::commit();

        $permission = Permission::whereName('verify-purchase')->first();
        foreach ($permission->roles as $role) {
            foreach ($role->getMorphByUserRelation('users')->get() as $user) {
                $user->notify(new VerifyPurchase($purchase->id));
            }
        }

        $message = Lang::get('Purchase number') . ' #' . $purchase->id . ' ' . Lang::get('successfully created.');
        return redirect()->route('purchase.index')->with('status', $message);
    }

    public function show($id)
    {
        if (!Laratrust::isAbleTo('view-purchase')) return abort(404);

        $purchase = PurchasePost::select('purchase_posts.id', 'purchase_posts.total_price', 'purchase_posts.status', 'suppliers.name AS supplier', 'master_payment_methods.name AS payment_method', 'purchase_posts.proof_of_payment')
                        ->leftJoin('suppliers', 'suppliers.id', '=', 'purchase_posts.supplier_id')
                        ->leftJoin('master_payment_methods', 'master_payment_methods.id', '=', 'purchase_posts.payment_method_id')
                        ->findOrFail($id);
        $purchaseDetails = PurchasePostDetail::select('purchase_post_details.price', 'purchase_post_details.quantity', 'purchase_post_details.note', 'purchase_post_details.is_guaranteed', 'purchase_post_details.warranty_expiration_date', 'purchase_post_details.warranty_terms_and_conditions', 'products.photo AS product_photo', 'products.code AS product_code', 'products.name AS product_name')
                ->leftJoin('products', 'products.id', '=', 'purchase_post_details.product_id')
                ->wherePurchasePostId($id)
                ->orderBy('products.code')
                ->get();
        $purchaseStatus = PurchasePostStatus::select('purchase_post_status.status', 'purchase_post_status.at', 'purchase_post_status.note', 'users.id AS user_id', 'users.name AS user_name', 'purchase_post_status.purchase_post_validate_id')
                ->leftJoin('users', 'users.id', '=', 'purchase_post_status.by')
                ->wherePurchasePostId($id)
                ->orderBy('purchase_post_status.at')
                ->get();

        return view('purchase.show', compact('purchase', 'purchaseDetails', 'purchaseStatus'));
    }

    public function void($id, Request $request)
    {
        if (!Laratrust::isAbleTo('void-purchase')) return abort(404);

        $purchase = PurchasePost::findOrFail($id);

        if ($purchase->status != 'Waiting for Approval' && $purchase->status != 'Approved' && $purchase->status != 'Postponed')
            return $this->validationError(Lang::get('This purchase cannot be voided.'));

        $this->validate($request, [
            'alasan' => ['required', 'string', 'max:255']
        ]);

        $this->updatePurchaseStatus($purchase, 'Voided', $request, $request->alasan);

        $message = Lang::get('Purchase number') . ' #' . $id . ' ' . Lang::get('successfully voided.');
        return redirect()->route('purchase.index')->with('status', $message);
    }

    public function approve($id, Request $request)
    {
        if (!Laratrust::isAbleTo('verify-purchase')) return abort(404);

        $purchase = PurchasePost::findOrFail($id);

        if ($purchase->status != 'Waiting for Approval' && $purchase->status != 'Postponed')
            return $this->validationError(Lang::get('This purchase cannot be approved.'));

        if ($purchase->total_price < 3000000) {
            $this->updatePurchaseStatus($purchase, 'Approved', $request);

            $permission = Permission::whereName('process-purchase')->first();
            foreach ($permission->roles as $role) {
                foreach ($role->getMorphByUserRelation('users')->get() as $user) {
                    $user->notify(new ProcessPurchase($purchase->id));
                }
            }
        } else {
            $permission = Permission::whereName('verify-purchase')->first();
            $totalUsers = 0;
            foreach ($permission->roles as $role) {
                $totalUsers += $role->getMorphByUserRelation('users')->count();
            }

            DB::beginTransaction();
            try {
                $userId = Auth::user()->id;

                $purchaseStatus = PurchasePostStatus::wherePurchasePostId($id)
                                    ->whereStatus('Approved')
                                    ->whereBy($userId)
                                    ->first();
                if ($purchaseStatus) return $this->validationError(Lang::get('You have approved to this purchase.'));
                else {
                    $purchaseStatus = new PurchasePostStatus;
                    $purchaseStatus->purchase_post_id = $purchase->id;
                    $purchaseStatus->status = 'Approved';
                    $purchaseStatus->at = now();
                    $purchaseStatus->by = $userId;
                    $purchaseStatus->save();

                    $totalApproved = PurchasePostStatus::wherePurchasePostId($id)->whereStatus('Approved')->count();
                    if ($totalApproved >= $totalUsers) {
                        $purchase->status = 'Approved';
                        $purchase->save();

                        $permission = Permission::whereName('process-purchase')->first();
                        foreach ($permission->roles as $role) {
                            foreach ($role->getMorphByUserRelation('users')->get() as $user) {
                                $user->notify(new ProcessPurchase($purchase->id));
                            }
                        }
                    }
                }
            } catch (Exception $e) {
                DB::rollBack();
                report($e);
                return abort(500);
            }
            DB::commit();
        }

        $message = Lang::get('Purchase number') . ' #' . $id . ' ' . Lang::get('successfully approved.');
        return redirect()->route('purchase.index')->with('status', $message);
    }

    public function postpone($id, Request $request)
    {
        if (!Laratrust::isAbleTo('verify-purchase')) return abort(404);

        $purchase = PurchasePost::findOrFail($id);

        if ($purchase->status != 'Waiting for Approval')
            return $this->validationError(Lang::get('This purchase cannot be postponed.'));

        $this->validate($request, [
            'alasan' => ['required', 'string', 'max:255']
        ]);

        $this->updatePurchaseStatus($purchase, 'Postponed', $request, $request->alasan);

        $purchaseStatus = PurchasePostStatus::select('by')->wherePurchasePostId($id)->whereStatus('Submitted')->first();
        $user = User::find($purchaseStatus->by);
        if ($user) $user->notify(new PostponePurchase($purchase->id));

        $message = Lang::get('Purchase number') . ' #' . $id . ' ' . Lang::get('successfully postponed.');
        return redirect()->route('purchase.index')->with('status', $message);
    }

    public function reject($id, Request $request)
    {
        if (!Laratrust::isAbleTo('verify-purchase')) return abort(404);

        $purchase = PurchasePost::findOrFail($id);

        if ($purchase->status != 'Waiting for Approval' && $purchase->status != 'Postponed')
            return $this->validationError(Lang::get('This purchase cannot be rejected.'));

        $this->validate($request, [
            'alasan' => ['required', 'string', 'max:255']
        ]);

        $this->updatePurchaseStatus($purchase, 'Rejected', $request, $request->alasan);

        $purchaseStatus = PurchasePostStatus::select('by')->wherePurchasePostId($id)->whereStatus('Submitted')->first();
        $user = User::find($purchaseStatus->by);
        if ($user) $user->notify(new RejectPurchase($purchase->id));

        $message = Lang::get('Purchase number') . ' #' . $id . ' ' . Lang::get('successfully rejected.');
        return redirect()->route('purchase.index')->with('status', $message);
    }

    public function process($id, Request $request)
    {
        if (!Laratrust::isAbleTo('process-purchase')) return abort(404);

        $purchase = PurchasePost::findOrFail($id);

        if ($purchase->status != 'Approved')
            return $this->validationError(Lang::get('This purchase cannot be processed.'));

        $rules = [
            'catatan' => ['nullable', 'string', 'max:255'],
        ];
        if (!$request->bayar_nanti) {
            $rules = array_merge($rules, [
                'bukti_pembayaran' => ['required', 'file', 'mimetypes:image/*,application/pdf'],
            ]);
        }
        $this->validate($request, $rules);

        $this->updatePurchaseStatus($purchase, 'Processed', $request, $request->catatan);

        $permission = Permission::whereName('validate-purchase')->first();
        foreach ($permission->roles as $role) {
            foreach ($role->getMorphByUserRelation('users')->get() as $user) {
                $user->notify(new ValidatePurchase($purchase->id));
            }
        }

        $message = Lang::get('Purchase number') . ' #' . $id . ' ' . Lang::get('successfully processed.');
        return redirect()->route('purchase.index')->with('status', $message);
    }

    public function showValidationForm($id)
    {
        if (!Laratrust::isAbleTo('validate-purchase')) return abort(404);

        $purchase = PurchasePost::select('purchase_posts.id', 'purchase_posts.total_price', 'purchase_posts.status', 'suppliers.name AS supplier', 'master_payment_methods.name AS payment_method', 'purchase_posts.proof_of_payment', 'purchase_posts.pay_later')
                ->leftJoin('suppliers', 'suppliers.id', '=', 'purchase_posts.supplier_id')
                ->leftJoin('master_payment_methods', 'master_payment_methods.id', '=', 'purchase_posts.payment_method_id')
                ->findOrFail($id);

        if ($purchase->status != 'Processed' && $purchase->status != 'Returned' && $purchase->status != 'Incomplete') {
            $message = Lang::get('Purchase number') . ' #' . $id . ' ' . Lang::get('cannot be validated.');
            return redirect()->route('purchase.index')->withErrors($message);
        }

        $purchaseDetails = PurchasePostDetail::select('purchase_post_details.price', 'purchase_post_details.quantity', 'products.photo AS product_photo', 'products.code AS product_code', 'products.name AS product_name', 'purchase_post_details.id')
                ->leftJoin('products', 'products.id', '=', 'purchase_post_details.product_id')
                ->wherePurchasePostId($id)
                ->orderBy('products.code')
                ->get();

        return view('purchase.validate.create', compact('purchase', 'purchaseDetails'));
    }

    public function processValidate($id, Request $request)
    {
        if (!Laratrust::isAbleTo('validate-purchase')) return abort(404);

        $purchase = PurchasePost::findOrFail($id);

        if ($purchase->status != 'Processed' && $purchase->status != 'Returned' && $purchase->status != 'Incomplete') {
            $message = Lang::get('Purchase number') . ' #' . $id . ' ' . Lang::get('cannot be validated.');
            return redirect()->route('purchase.index')->withErrors($message);
        }

        $rules = [
            'catatan' => ['nullable', 'string', 'max:255'],
            'barang' => ['required'],
            'barang.*.kurang' => ['required', 'numeric', 'min:0'],
            'barang.*.cacat' => ['required', 'numeric', 'min:0'],
        ];
        if (!$purchase->proof_of_payment && !$request->bayar_nanti) {
            $rules = array_merge($rules, [
                'bukti_pembayaran' => ['required', 'file', 'mimetypes:image/*,application/pdf'],
            ]);
        }
        $this->validate($request, $rules);

        DB::beginTransaction();
        try {
            $purchaseDetails = PurchasePostDetail::wherePurchasePostId($id)->lockForUpdate()->get();

            foreach ($request->barang as $purchaseDetailId => $value) {
                if (!$purchaseDetails->find($purchaseDetailId))
                    throw new Exception('[Validate Purchase] PurchasePostDetail with id = ' . $purchaseDetailId . ' not found.');
            }

            $purchaseValidate = new PurchasePostValidate;
            $purchaseValidate->purchase_post_id = $purchase->id;
            $purchaseValidate->save();

            $totalLack = 0;
            $totalDefective = 0;
            foreach ($purchaseDetails as $purchaseDetail) {
                $quantity = json_decode($purchaseDetail->quantity);
                $totalUnvalidated = $quantity->ordered - $quantity->validated;
                $totalValidated = (int) ($request->barang[$purchaseDetail->id]['kurang'] + $request->barang[$purchaseDetail->id]['cacat']);
                if ($totalValidated > $totalUnvalidated)
                    return $this->validationError(Lang::get('The quantity of validated products cannot be greater than the quantity of products that have not been validated.'));

                $purchaseValidateDetail = new PurchasePostValidateDetail;
                $purchaseValidateDetail->purchase_post_validate_id = $purchaseValidate->id;
                $purchaseValidateDetail->purchase_post_detail_id = $purchaseDetail->id;
                $purchaseValidateDetail->lack = $request->barang[$purchaseDetail->id]['kurang'];
                $purchaseValidateDetail->defective = $request->barang[$purchaseDetail->id]['cacat'];
                $purchaseValidateDetail->save();

                $purchaseDetail->quantity = json_encode([
                    'ordered' => (int) $quantity->ordered,
                    'validated' => (int) ($quantity->validated + $totalUnvalidated - $totalValidated),
                    'storaged' => (int) $quantity->storaged
                ]);
                $purchaseDetail->save();

                $totalLack += $request->barang[$purchaseDetail->id]['kurang'];
                $totalDefective += $request->barang[$purchaseDetail->id]['cacat'];
            }

            $status = ($totalLack + $totalDefective) == 0 && ($purchase->proof_of_payment || $request->bukti_pembayaran) ? 'Completed'
                        : ($totalDefective > 0 ? 'Returned'
                            : 'Incomplete');
        } catch (Exception $e) {
            DB::rollBack();
            report($e);
            return abort(500);
        }
        DB::commit();

        $this->updatePurchaseStatus($purchase, $status, $request, $request->catatan, $purchaseValidate->id);

        // kirim notif ke role yg punya permission pemasukan barang baru

        $message = Lang::get('Purchase number') . ' #' . $id . ' ' . Lang::get('successfully validated.');
        return redirect()->route('purchase.index')->with('status', $message);
    }

    public function showValidationDetails($id, $validateId)
    {
        if (!Laratrust::isAbleTo('view-purchase')) return abort(404);

        $purchaseValidate = PurchasePostValidate::select('purchase_posts.id', 'purchase_posts.total_price', 'suppliers.name AS supplier', 'master_payment_methods.name AS payment_method', 'purchase_posts.proof_of_payment')
                ->leftJoin('purchase_posts', 'purchase_posts.id', '=', 'purchase_post_validates.purchase_post_id')
                ->leftJoin('suppliers', 'suppliers.id', '=', 'purchase_posts.supplier_id')
                ->leftJoin('master_payment_methods', 'master_payment_methods.id', '=', 'purchase_posts.payment_method_id')
                ->where('purchase_post_validates.purchase_post_id', $id)
                ->where('purchase_post_validates.id', $validateId)
                ->firstOrFail();
        $purchaseValidateDetails = PurchasePostValidateDetail::select('products.photo AS product_photo', 'products.code AS product_code', 'products.name AS product_name', 'purchase_post_validate_details.lack', 'purchase_post_validate_details.defective')
                ->leftJoin('purchase_post_details', 'purchase_post_details.id', '=', 'purchase_post_validate_details.purchase_post_detail_id')
                ->leftJoin('products', 'products.id', '=', 'purchase_post_details.product_id')
                ->where('purchase_post_validate_details.purchase_post_validate_id', $validateId)
                ->orderBy('products.code')
                ->get();

        return view('purchase.validate.show', compact('purchaseValidate', 'purchaseValidateDetails'));
    }

    private function updatePurchaseStatus($purchase, $newStatus, $request, $note = null, $purchaseValidateId = null) {
        DB::beginTransaction();
        try {
            $purchase->status = $newStatus;
            $purchase->pay_later = $request->bayar_nanti ? 1 : 0;
            if (!$request->bayar_nanti && $request->bukti_pembayaran) {
                $filePath = $request->file('bukti_pembayaran')->store('public/purchases');
                $fileUrl = url('/storage') . str_replace('public', '', $filePath);
                $purchase->proof_of_payment = $fileUrl;
            }
            $purchase->save();

            $purchaseStatus = new PurchasePostStatus;
            $purchaseStatus->purchase_post_id = $purchase->id;
            $purchaseStatus->status = $newStatus;
            $purchaseStatus->at = now();
            $purchaseStatus->by = Auth::user()->id;
            $purchaseStatus->note = $note;
            $purchaseStatus->purchase_post_validate_id = $purchaseValidateId;
            $purchaseStatus->save();
        } catch (Exception $e) {
            DB::rollBack();
            report($e);
            return abort(500);
        }
        DB::commit();

        return;
    }
}
