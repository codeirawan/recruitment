<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use Laratrust, DataTables, Lang;
use App\Models\Master\ProductUnit;
use App\Http\Controllers\Controller;

class ProductUnitController extends Controller
{
    public function index()
    {
        if (!Laratrust::can('view-product-unit')) return abort(404);

        return view('master.product-unit.index');
    }

    public function data()
    {
        if (!Laratrust::can('view-product-unit')) return abort(404);

        $productUnits = ProductUnit::select('id', 'name');

        return DataTables::of($productUnits)
            ->addColumn('action', function($productUnit) {
                $edit = '<a href="' . route('master.product-unit.edit', $productUnit->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Edit') . '"><i class="la la-edit"></i></a>';
                $delete = '<a href="#" data-href="' . route('master.product-unit.destroy', $productUnit->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Delete') . '" data-toggle="modal" data-target="#modal-delete" data-key="' . $productUnit->name . '"><i class="la la-trash"></i></a>';

                return (Laratrust::can('update-product-unit') ? $edit : '') . (Laratrust::can('delete-product-unit') ? $delete : '');
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        if (!Laratrust::can('create-product-unit')) return abort(404);

        return view('master.product-unit.create');
    }

    public function store(Request $request)
    {
        if (!Laratrust::can('create-product-unit')) return abort(404);

        $this->validate($request, [
            'nama' => ['required', 'string', 'max:255'],
        ]);

        $productUnit = new ProductUnit;
        $productUnit->name = $request->nama;
        $productUnit->save();

        $message = Lang::get('Product unit') . ' \'' . $productUnit->name . '\' ' . Lang::get('successfully created.');
        return redirect()->route('master.product-unit.index')->with('status', $message);
    }

    public function edit($id)
    {
        if (!Laratrust::can('update-product-unit')) return abort(404);

        $productUnit = ProductUnit::select('id', 'name')->findOrFail($id);

        return view('master.product-unit.edit', compact('productUnit'));
    }

    public function update($id, Request $request)
    {
        if (!Laratrust::can('update-product-unit')) return abort(404);

        $productUnit = ProductUnit::findOrFail($id);

        $this->validate($request, [
            'nama' => ['required', 'string', 'max:255'],
        ]);

        $productUnit->name = $request->nama;
        $productUnit->save();

        $message = Lang::get('Product unit') . ' \'' . $productUnit->name . '\' ' . Lang::get('successfully updated.');
        return redirect()->route('master.product-unit.index')->with('status', $message);
    }

    public function destroy($id)
    {
        if (!Laratrust::can('delete-product-unit')) return abort(404);

        $productUnit = ProductUnit::findOrFail($id);
        $name = $productUnit->name;
        $productUnit->delete();

        $message = Lang::get('Product unit') . ' \'' . $name . '\' ' . Lang::get('successfully deleted.');
        return redirect()->route('master.product-unit.index')->with('status', $message);
    }
}
