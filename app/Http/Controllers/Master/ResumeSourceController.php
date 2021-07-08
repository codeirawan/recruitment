<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laratrust, DataTables, Lang;
use App\Models\Master\ResumeSource;

class ResumeSourceController extends Controller
{
    public function index()
    {
        if (!Laratrust::isAbleTo('view-resume-source')) return abort(404);

        return view('master.resume-source.index');
    }

    public function data()
    {
        if (!Laratrust::isAbleTo('view-resume-source')) return abort(404);

        $resumeSources = ResumeSource::select('id', 'name');

        return DataTables::of($resumeSources)
            ->addColumn('action', function($resumeSource) {
                $edit = '<a href="' . route('master.resume-source.edit', $resumeSource->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Edit') . '"><i class="la la-edit"></i></a>';
                $delete = '<a href="#" data-href="' . route('master.resume-source.destroy', $resumeSource->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Delete') . '" data-toggle="modal" data-target="#modal-delete" data-key="' . $resumeSource->name . '"><i class="la la-trash"></i></a>';

                return (Laratrust::isAbleTo('update-resume-source') ? $edit : '') . (Laratrust::isAbleTo('delete-resume-source') ? $delete : '');
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        if (!Laratrust::isAbleTo('create-resume-source')) return abort(404);

        return view('master.resume-source.create');
    }

    public function store(Request $request)
    {
        if (!Laratrust::isAbleTo('create-resume-source')) return abort(404);

        $this->validate($request, [
            'nama' => ['required', 'string', 'max:255'],
        ]);

        $resumeSource = new ResumeSource;
        $resumeSource->name = $request->nama;
        $resumeSource->save();

        $message = Lang::get('Resume source') . ' \'' . $resumeSource->name . '\' ' . Lang::get('successfully created.');
        return redirect()->route('master.resume-source.index')->with('status', $message);
    }

    public function edit($id)
    {
        if (!Laratrust::isAbleTo('update-resume-source')) return abort(404);

        $resumeSource = ResumeSource::select('id', 'name')->findOrFail($id);

        return view('master.resume-source.edit', compact('resumeSource'));
    }

    public function update($id, Request $request)
    {
        if (!Laratrust::isAbleTo('update-resume-source')) return abort(404);

        $resumeSource = ResumeSource::findOrFail($id);

        $this->validate($request, [
            'nama' => ['required', 'string', 'max:255'],
        ]);

        $resumeSource->name = $request->nama;
        $resumeSource->save();

        $message = Lang::get('Resume source') . ' \'' . $resumeSource->name . '\' ' . Lang::get('successfully updated.');
        return redirect()->route('master.resume-source.index')->with('status', $message);
    }

    public function destroy($id)
    {
        if (!Laratrust::isAbleTo('delete-resume-source')) return abort(404);

        $resumeSource = ResumeSource::findOrFail($id);
        $name = $resumeSource->name;
        $resumeSource->delete();

        $message = Lang::get('Resume source') . ' \'' . $name . '\' ' . Lang::get('successfully deleted.');
        return redirect()->route('master.resume-source.index')->with('status', $message);
    }
}
