<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Models\Master\ProductUnit;
use App\Http\Controllers\Controller;
use App\Models\Master\ProductCategory;
use Laratrust, Lang, DataTables, Storage;

class ProductController extends Controller
{
    public function index()
    {
        if (!Laratrust::isAbleTo('view-product')) return abort(404);

        return view('product.index');
    }

    public function data()
    {
        if (!Laratrust::isAbleTo('view-product')) return abort(404);

        $products = Product::select('products.id', 'products.code', 'products.name', 'master_product_categories.name AS category', 'master_product_units.name AS unit', 'products.stock', 'products.photo', 'products.sku_per_unit', 'products.mac_address')
                        ->leftJoin('master_product_categories', 'master_product_categories.id', '=', 'products.category_id')
                        ->leftJoin('master_product_units', 'master_product_units.id', '=', 'products.unit_id');

        return DataTables::of($products)
            ->editColumn('photo', function($product) {
                return '<a href="' . $product->photo . '" class="kt-media kt-media--lg" target="_blank"><img src="' . $product->photo . '"></a>';
            })
            ->editColumn('stock', function($product) {
                $stock = json_decode($product->stock);

                $new = '<i class="la la-check text-primary font-weight-bold btn-tooltip" title="' . Lang::get('New') . '"></i> ' . number_format($stock->new) . '<br>';
                $secondhand = '<i class="la la-refresh text-success font-weight-bold btn-tooltip" title="' . Lang::get('Secondhand') . '"></i> ' . number_format($stock->secondhand) . '<br>';
                $damaged = '<i class="la la-times text-warning font-weight-bold btn-tooltip" title="' . Lang::get('Damaged') . '"></i> ' . number_format($stock->damaged) . '<br>';
                $lost = '<i class="la la-question text-danger font-weight-bold btn-tooltip" title="' . Lang::get('Lost') . '"></i> ' . number_format($stock->lost);

                return $new . $secondhand . $damaged . $lost;
            })
            ->editColumn('sku_per_unit', function($product) {
                return $product->sku_per_unit
                    ? '<i class="la la-check text-success font-weight-bold"></i>'
                    : '<i class="la la-times text-danger font-weight-bold"></i>';
            })
            ->editColumn('mac_address', function($product) {
                return $product->mac_address
                    ? '<i class="la la-check text-success font-weight-bold"></i>'
                    : '<i class="la la-times text-danger font-weight-bold"></i>';
            })
            ->addColumn('action', function($product) {
                $edit = '<a href="' . route('product.edit', $product->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Edit') . '"><i class="la la-edit"></i></a>';
                $delete = '<a href="#" data-href="' . route('product.destroy', $product->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Delete') . '" data-toggle="modal" data-target="#modal-delete" data-key="' . $product->name . '"><i class="la la-trash"></i></a>';

                return (Laratrust::isAbleTo('update-product') ? $edit : '') . (Laratrust::isAbleTo('delete-product') ? $delete : '');
            })
            ->rawColumns(['photo', 'stock', 'sku_per_unit', 'action', 'mac_address'])
            ->make(true);
    }

    public function create()
    {
        if (!Laratrust::isAbleTo('create-product')) return abort(404);

        $productCategories = ProductCategory::select('id', 'name', 'code')->orderBy('name')->get();
        $productUnits = ProductUnit::select('id', 'name')->orderBy('name')->get();

        return view('product.create', compact('productCategories', 'productUnits'));
    }

    public function store(Request $request)
    {
        if (!Laratrust::isAbleTo('create-product')) return abort(404);

        $this->validate($request, [
            'kode' => 'required',
            'nama' => 'required',
            'kategori' => 'required|integer',
            'satuan' => 'required|integer|exists:master_product_units,id,deleted_at,NULL',
            'foto' => 'required|file|image',
        ]);

        if (Product::whereCode($request->kode)->exists())
            return $this->validationError(Lang::get('The code has already been taken.'));

        $productCategory = ProductCategory::select('code')->find($request->kategori);
        if (!$productCategory) return $this->validationError(Lang::get('The selected category is invalid.'));

        $photoPath = $request->file('foto')->store('public/products');
        $photoUrl = url('/storage') . str_replace('public', '', $photoPath);

        $product = new Product;
        $product->code = $productCategory->code . $request->kode;
        $product->name = $request->nama;
        $product->category_id = $request->kategori;
        $product->unit_id = $request->satuan;
        $product->stock = json_encode([
            'new' => 0,
            'secondhand' => 0,
            'damaged' => 0,
            'lost' => 0
        ]);
        $product->photo = $photoUrl;
        $product->sku_per_unit = $request->sku_per_satuan ? 1 : 0;
        $product->mac_address = $request->alamat_mac ? 1 : 0;
        $product->save();

        $message = Lang::get('Product') . ' \'' . $product->name . '\' ' . Lang::get('successfully created.');
        return redirect()->route('product.index')->with('status', $message);
    }

    public function edit($id)
    {
        if (!Laratrust::isAbleTo('update-product')) return abort(404);

        $product = Product::select('products.id', 'products.code', 'products.name', 'products.category_id', 'products.unit_id', 'products.photo', 'products.sku_per_unit', 'products.mac_address', 'master_product_categories.code AS category_code')
                        ->leftJoin('master_product_categories', 'master_product_categories.id', '=', 'products.category_id')
                        ->findOrFail($id);
        $productCategories = ProductCategory::select('id', 'name', 'code')->orderBy('name')->get();
        $productUnits = ProductUnit::select('id', 'name')->orderBy('name')->get();

        return view('product.edit', compact('product', 'productCategories', 'productUnits'));
    }

    public function update($id, Request $request)
    {
        if (!Laratrust::isAbleTo('update-product')) return abort(404);

        $product = Product::findOrFail($id);

        $this->validate($request, [
            'kode' => 'required',
            'nama' => 'required',
            'kategori' => 'required|integer',
            'satuan' => 'required|integer|exists:master_product_units,id,deleted_at,NULL',
            'foto' => 'nullable|file|image',
        ]);

        if (Product::whereCode($request->kode)->where('id', '<>', $id)->exists())
            return $this->validationError(Lang::get('The code has already been taken.'));

        $productCategory = ProductCategory::select('code')->find($request->kategori);
        if (!$productCategory) return $this->validationError(Lang::get('The selected category is invalid.'));

        if ($request->foto) {
            Storage::delete(str_replace(url('/storage'), 'public', $product->photo));

            $photoPath = $request->file('foto')->store('public/products');
            $photoUrl = url('/storage') . str_replace('public', '', $photoPath);

            $product->photo = $photoUrl;
        }

        $product->code = $productCategory->code . $request->kode;
        $product->name = $request->nama;
        $product->category_id = $request->kategori;
        $product->unit_id = $request->satuan;
        $product->sku_per_unit = $request->sku_per_satuan ? 1 : 0;
        $product->mac_address = $request->alamat_mac ? 1 : 0;
        $product->save();

        $message = Lang::get('Product') . ' \'' . $product->name . '\' ' . Lang::get('successfully updated.');
        return redirect()->route('product.index')->with('status', $message);
    }

    public function destroy($id)
    {
        if (!Laratrust::isAbleTo('delete-product')) return abort(404);

        $product = Product::findOrFail($id);
        Storage::delete(str_replace(url('/storage'), 'public', $product->photo));
        $name = $product->name;
        $product->delete();

        $message = Lang::get('Product') . ' \'' . $name . '\' ' . Lang::get('successfully deleted.');
        return redirect()->route('product.index')->with('status', $message);
    }
}
