<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Models\Product\Supplier;
use App\Http\Controllers\Controller;
use App\Models\Master\ProductCategory;
use App\Models\Product\ProductSupplier;
use Laratrust, DataTables, Lang, DB, Exception;

class SupplierController extends Controller
{
    public function index()
    {
        if (!Laratrust::isAbleTo('view-supplier')) return abort(404);

        return view('supplier.index');
    }

    public function data()
    {
        if (!Laratrust::isAbleTo('view-supplier')) return abort(404);

        $suppliers = Supplier::select('id', 'name', 'telephone', 'address', 'type', 'npwp');

        return DataTables::of($suppliers)
            ->addColumn('action', function($supplier) {
                $view = '<a href="' . route('supplier.show', $supplier->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('View') . '"><i class="la la-eye"></i></a>';
                $edit = '<a href="' . route('supplier.edit', $supplier->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Edit') . '"><i class="la la-edit"></i></a>';
                $delete = '<a href="#" data-href="' . route('supplier.destroy', $supplier->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Delete') . '" data-toggle="modal" data-target="#modal-delete" data-key="' . $supplier->name . '"><i class="la la-trash"></i></a>';

                return (Laratrust::isAbleTo('view-supplier') ? $view : '') . (Laratrust::isAbleTo('update-supplier') ? $edit : '') . (Laratrust::isAbleTo('delete-supplier') ? $delete : '');
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        if (!Laratrust::isAbleTo('create-supplier')) return abort(404);

        $productCategories = ProductCategory::select('id', 'name', 'code')->orderBy('name')->get();

        return view('supplier.create', compact('productCategories'));
    }

    public function store(Request $request)
    {
        if (!Laratrust::isAbleTo('create-supplier')) return abort(404);

        $this->validate($request, [
            'nama' => ['required', 'string', 'max:255'],
            'jenis' => ['required', 'in:Individual,PT,CV'],
            'nomor_telepon' => ['required', 'numeric', 'digits_between:5,15'],
            'npwp' => ['required', 'numeric', 'digits_between:5,18'],
            'alamat' => ['required'],
            'barang' => ['required'],
            'barang.*' => ['required', 'integer', 'exists:products,id,deleted_at,NULL']
        ]);

        $productIds = [];
        foreach ($request->barang as $productId) {
            array_push($productIds, $productId);
        }

        DB::beginTransaction();
        try {
            $supplier = new Supplier;
            $supplier->name = $request->nama;
            $supplier->telephone = $request->nomor_telepon;
            $supplier->address = $request->alamat;
            $supplier->type = $request->jenis;
            $supplier->npwp = $request->npwp;
            $supplier->save();

            $supplier->products()->attach($productIds);
        } catch (Exception $e) {
            DB::rollBack();
            report($e);
            return abort(500);
        }
        DB::commit();

        $message = Lang::get('Supplier') . ' \'' . $supplier->name . '\' ' . Lang::get('successfully created.');
        return redirect()->route('supplier.index')->with('status', $message);
    }

    public function show($id)
    {
        if (!Laratrust::isAbleTo('view-supplier')) return abort(404);

        $supplier = Supplier::select('id', 'name', 'type', 'telephone', 'npwp', 'address')->findOrFail($id);

        return view('supplier.show', compact('supplier'));
    }

    public function getProductData($id)
    {
        if (!Laratrust::isAbleTo('view-supplier')) return abort(404);

        $productIds = ProductSupplier::select('product_id')->whereSupplierId($id)->pluck('product_id');
        $products = Product::select('products.id', 'products.code', 'products.name', 'products.photo', 'master_product_categories.code AS category_code', 'master_product_categories.name AS category_name')
                ->leftJoin('master_product_categories', 'master_product_categories.id', '=', 'products.category_id')
                ->whereIn('products.id', $productIds);

        return DataTables::of($products)
            ->editColumn('photo', function($product) {
                return '<a href="' . $product->photo . '" class="kt-media kt-media--lg" target="_blank"><img src="' . $product->photo . '"></a>';
            })
            ->editColumn('category', function($product) {
                return $product->category_name . ' (' . $product->category_code . ')';
            })
            ->rawColumns(['photo'])
            ->make(true);
    }

    public function edit($id)
    {
        if (!Laratrust::isAbleTo('update-supplier')) return abort(404);

        $supplier = Supplier::select('id', 'name', 'type', 'telephone', 'npwp', 'address')->findOrFail($id);
        $productIds = ProductSupplier::select('product_id')->whereSupplierId($id)->pluck('product_id');
        $products = Product::select('products.id', 'products.code', 'products.name', 'products.photo', 'master_product_categories.code AS category_code', 'master_product_categories.name AS category_name')
                ->leftJoin('master_product_categories', 'master_product_categories.id', '=', 'products.category_id')
                ->whereIn('products.id', $productIds)
                ->orderBy('products.code')
                ->get();
        $productCategories = ProductCategory::select('id', 'name', 'code')->orderBy('name')->get();

        return view('supplier.edit', compact('supplier', 'products', 'productCategories'));
    }

    public function update($id, Request $request)
    {
        if (!Laratrust::isAbleTo('update-supplier')) return abort(404);

        $supplier = Supplier::findOrFail($id);

        $this->validate($request, [
            'nama' => ['required', 'string', 'max:255'],
            'jenis' => ['required', 'in:Individual,PT,CV'],
            'nomor_telepon' => ['required', 'numeric', 'digits_between:5,15'],
            'npwp' => ['required', 'numeric', 'digits_between:5,18'],
            'alamat' => ['required'],
            'barang' => ['required'],
            'barang.*' => ['required', 'integer', 'exists:products,id,deleted_at,NULL']
        ]);

        $productIds = [];
        foreach ($request->barang as $productId) {
            array_push($productIds, $productId);
        }

        DB::beginTransaction();
        try {
            $supplier->name = $request->nama;
            $supplier->telephone = $request->nomor_telepon;
            $supplier->address = $request->alamat;
            $supplier->type = $request->jenis;
            $supplier->npwp = $request->npwp;
            $supplier->save();

            $supplier->products()->sync($productIds);
        } catch (Exception $e) {
            DB::rollBack();
            report($e);
            return abort(500);
        }
        DB::commit();

        $message = Lang::get('Supplier') . ' \'' . $supplier->name . '\' ' . Lang::get('successfully updated.');
        return redirect()->route('supplier.index')->with('status', $message);
    }

    public function destroy($id)
    {
        if (!Laratrust::isAbleTo('delete-supplier')) return abort(404);

        $supplier = Supplier::findOrFail($id);
        $name = $supplier->name;
        $supplier->delete();

        $message = Lang::get('Supplier') . ' \'' . $name . '\' ' . Lang::get('successfully deleted.');
        return redirect()->route('supplier.index')->with('status', $message);
    }
}
