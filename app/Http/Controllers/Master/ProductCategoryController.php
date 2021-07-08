<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use Laratrust, DataTables, Lang;
use App\Http\Controllers\Controller;
use App\Models\Master\ProductCategory;

class ProductCategoryController extends Controller
{
    public function index()
    {
        if (!Laratrust::can('view-product-category')) return abort(404);

        return view('master.product-category.index');
    }

    public function data()
    {
        if (!Laratrust::can('view-product-category')) return abort(404);

        $productCategories = ProductCategory::select('id', 'name', 'code');

        return DataTables::of($productCategories)
            ->addColumn('action', function($productCategory) {
                $edit = '<a href="' . route('master.product-category.edit', $productCategory->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Edit') . '"><i class="la la-edit"></i></a>';
                $delete = '<a href="#" data-href="' . route('master.product-category.destroy', $productCategory->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Delete') . '" data-toggle="modal" data-target="#modal-delete" data-key="' . $productCategory->name . '"><i class="la la-trash"></i></a>';

                return (Laratrust::can('update-product-category') ? $edit : '') . (Laratrust::can('delete-product-category') ? $delete : '');
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        if (!Laratrust::can('create-product-category')) return abort(404);

        return view('master.product-category.create');
    }

    public function store(Request $request)
    {
        if (!Laratrust::can('create-product-category')) return abort(404);

        $this->validate($request, [
            'kode' => ['required', 'string', 'max:255'],
            'nama' => ['required', 'string', 'max:255'],
        ]);

        if (ProductCategory::whereCode($request->kode)->exists())
            return $this->validationError(Lang::get('The code has already been taken.'));

        $productCategory = new ProductCategory;
        $productCategory->code = $request->kode;
        $productCategory->name = $request->nama;
        $productCategory->save();

        $message = Lang::get('Product category') . ' \'' . $productCategory->name . '\' ' . Lang::get('successfully created.');
        return redirect()->route('master.product-category.index')->with('status', $message);
    }

    public function edit($id)
    {
        if (!Laratrust::can('update-product-category')) return abort(404);

        $productCategory = ProductCategory::select('id', 'name', 'code')->findOrFail($id);

        return view('master.product-category.edit', compact('productCategory'));
    }

    public function update($id, Request $request)
    {
        if (!Laratrust::can('update-product-category')) return abort(404);

        $productCategory = ProductCategory::findOrFail($id);

        $this->validate($request, [
            'kode' => ['required', 'string', 'max:255'],
            'nama' => ['required', 'string', 'max:255'],
        ]);

        if (ProductCategory::whereCode($request->kode)->where('id', '<>', $id)->exists())
            return $this->validationError(Lang::get('The code has already been taken.'));

        $productCategory->code = $request->kode;
        $productCategory->name = $request->nama;
        $productCategory->save();

        $message = Lang::get('Product category') . ' \'' . $productCategory->name . '\' ' . Lang::get('successfully updated.');
        return redirect()->route('master.product-category.index')->with('status', $message);
    }

    public function destroy($id)
    {
        if (!Laratrust::can('delete-product-category')) return abort(404);

        $productCategory = ProductCategory::findOrFail($id);
        $name = $productCategory->name;
        $productCategory->delete();

        $message = Lang::get('Product category') . ' \'' . $name . '\' ' . Lang::get('successfully deleted.');
        return redirect()->route('master.product-category.index')->with('status', $message);
    }
}
