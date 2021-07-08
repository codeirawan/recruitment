<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use Laratrust, DataTables, Lang;
use App\Http\Controllers\Controller;
use App\Models\Master\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function index()
    {
        if (!Laratrust::can('view-payment-method')) return abort(404);

        return view('master.payment-method.index');
    }

    public function data()
    {
        if (!Laratrust::can('view-payment-method')) return abort(404);

        $paymentMethods = PaymentMethod::select('id', 'name');

        return DataTables::of($paymentMethods)
            ->addColumn('action', function($paymentMethod) {
                $edit = '<a href="' . route('master.payment-method.edit', $paymentMethod->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Edit') . '"><i class="la la-edit"></i></a>';
                $delete = '<a href="#" data-href="' . route('master.payment-method.destroy', $paymentMethod->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Delete') . '" data-toggle="modal" data-target="#modal-delete" data-key="' . $paymentMethod->name . '"><i class="la la-trash"></i></a>';

                return (Laratrust::can('update-payment-method') ? $edit : '') . (Laratrust::can('delete-payment-method') ? $delete : '');
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        if (!Laratrust::can('create-payment-method')) return abort(404);

        return view('master.payment-method.create');
    }

    public function store(Request $request)
    {
        if (!Laratrust::can('create-payment-method')) return abort(404);

        $this->validate($request, [
            'nama' => ['required', 'string', 'max:255'],
        ]);

        $paymentMethod = new PaymentMethod;
        $paymentMethod->name = $request->nama;
        $paymentMethod->save();

        $message = Lang::get('Payment method') . ' \'' . $paymentMethod->name . '\' ' . Lang::get('successfully created.');
        return redirect()->route('master.payment-method.index')->with('status', $message);
    }

    public function edit($id)
    {
        if (!Laratrust::can('update-payment-method')) return abort(404);

        $paymentMethod = PaymentMethod::select('id', 'name')->findOrFail($id);

        return view('master.payment-method.edit', compact('paymentMethod'));
    }

    public function update($id, Request $request)
    {
        if (!Laratrust::can('update-payment-method')) return abort(404);

        $paymentMethod = PaymentMethod::findOrFail($id);

        $this->validate($request, [
            'nama' => ['required', 'string', 'max:255'],
        ]);

        $paymentMethod->name = $request->nama;
        $paymentMethod->save();

        $message = Lang::get('Payment method') . ' \'' . $paymentMethod->name . '\' ' . Lang::get('successfully updated.');
        return redirect()->route('master.payment-method.index')->with('status', $message);
    }

    public function destroy($id)
    {
        if (!Laratrust::can('delete-payment-method')) return abort(404);

        $paymentMethod = PaymentMethod::findOrFail($id);
        $name = $paymentMethod->name;
        $paymentMethod->delete();

        $message = Lang::get('Payment method') . ' \'' . $name . '\' ' . Lang::get('successfully deleted.');
        return redirect()->route('master.payment-method.index')->with('status', $message);
    }
}
