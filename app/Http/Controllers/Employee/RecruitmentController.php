<?php

namespace App\Http\Controllers\Employee;

use Carbon\Carbon;
use App\Models\Master\City;
use Illuminate\Http\Request;
use App\Models\Master\FileType;
use App\Models\Master\Position;
use App\Models\Employee\Applicant;
use App\Models\Master\ResumeSource;
use App\Http\Controllers\Controller;
use App\Models\Employee\ApplicantFile;
use App\Models\Employee\ApplicantStatus;
use Laratrust, DataTables, Lang, DB, Exception, Auth, Storage;

class RecruitmentController extends Controller
{
    public function index()
    {
        if (!Laratrust::isAbleTo('view-recruitment')) return abort(404);

        $fileTypes = FileType::select('id', 'name')->orderBy('name')->get();

        return view('employee.recruitment.index', compact('fileTypes'));
    }

    public function data()
    {
        if (!Laratrust::isAbleTo('view-recruitment')) return abort(404);

        $applicants = Applicant::select('applicants.id', 'applicants.name', 'applicants.email','applicants.phone_number', 'applicants.resume', 'master_resume_sources.name AS resume_source', 'master_positions.name AS position', 'master_cities.name AS city', 'applicants.interview_at', 'applicants.status')
                ->leftJoin('master_resume_sources', 'master_resume_sources.id', '=', 'applicants.resume_source_id')
                ->leftJoin('master_positions', 'master_positions.id', '=', 'applicants.position_id')
                ->leftJoin('master_cities', 'master_cities.id', '=', 'applicants.city_id');

        return DataTables::of($applicants)
            ->editColumn('interview_at', function($applicant) {
                return optional($applicant->interview_at)->format('d-m-Y, H:i');
            })
            ->editColumn('status', function($applicant) {
                $color = $applicant->status == 'Pending' ? 'light'
                            : ($applicant->status == 'Qualified' ? 'success'
                                : ($applicant->status == 'Not Qualified' ? 'danger'
                                    : ($applicant->status == 'Canceled' ? 'warning'
                                        : ($applicant->status == 'Scheduled' ? 'info'
                                            : ($applicant->status == 'Passed' ? 'primary'
                                                : 'secondary')))));

                return '<span class="badge badge-' . $color . '">' . Lang::get($applicant->status) . '</span>';
            })
            ->addColumn('action', function($applicant) {
                $resume = '<a href="' . $applicant->resume . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('View') . ' ' . Lang::get('Resume') . '" target="_blank"><i class="la la-file-pdf-o"></i></a>';
                $view = '<a href="' . route('recruitment.show', $applicant->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('View') . '"><i class="la la-eye"></i></a>';
                $edit = '<a href="' . route('recruitment.edit', $applicant->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Edit') . '"><i class="la la-edit"></i></a>';
                $delete = '<a href="#" data-href="' . route('recruitment.destroy', $applicant->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Delete') . '" data-toggle="modal" data-target="#modal-delete" data-key="' . $applicant->name . '"><i class="la la-trash"></i></a>';
                $verify = '<a href="#" data-id="' . $applicant->id . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Verify') . '" data-toggle="modal" data-target="#modal-verify" data-key="' . $applicant->name . '"><i class="la la-check"></i></a>';
                $cancel = '<a href="#" data-href="' . route('recruitment.cancel', $applicant->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Cancel') . '" data-toggle="modal" data-target="#modal-cancel"><i class="la la-ban"></i></a>';
                $schedule = '<a href="#" data-href="' . route('recruitment.schedule', $applicant->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Create Interview Schedule') . '" data-toggle="modal" data-target="#modal-schedule"><i class="la la-calendar"></i></a>';
                $validate = '<a href="#" data-id="' . $applicant->id . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Validate') . '" data-toggle="modal" data-target="#modal-validate" data-key="' . $applicant->name . '"><i class="fa fa-user-check"></i></a>';

                return $resume . $view
                    . (Laratrust::isAbleTo('update-recruitment') && $applicant->status == 'Pending' ? $edit : '')
                    . (Laratrust::isAbleTo('verify-recruitment') && $applicant->status == 'Pending' ? $verify : '')
                    . (Laratrust::isAbleTo('validate-recruitment') && $applicant->status == 'Scheduled' ? $validate : '')
                    . (Laratrust::isAbleTo('create-schedule-recruitment') && ($applicant->status == 'Qualified' || $applicant->status == 'Scheduled') ? $schedule : '')
                    . (Laratrust::isAbleTo('cancel-recruitment') && ($applicant->status == 'Qualified' || $applicant->status == 'Scheduled' || $applicant->status == 'Passed') ? $cancel : '')
                    . (Laratrust::isAbleTo('delete-recruitment') && $applicant->status == 'Pending' ? $delete : '');
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function create()
    {
        if (!Laratrust::isAbleTo('create-recruitment')) return abort(404);

        $resumeSources = ResumeSource::select('id', 'name')->orderBy('name')->get();
        $positions = Position::select('id', 'name')->orderBy('name')->get();
        $cities = City::select('id', 'name')->orderBy('name')->get();

        return view('employee.recruitment.create', compact('resumeSources', 'positions', 'cities'));
    }

    public function store(Request $request)
    {
        if (!Laratrust::isAbleTo('create-recruitment')) return abort(404);

        $this->validate($request, [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'nomor_telepon' => 'nullable|numeric|digits_between:11,15',
            'cv' => 'required|file|mimetypes:application/pdf',
            'sumber_cv' => 'required|integer|exists:master_resume_sources,id,deleted_at,NULL',
            'jabatan' => 'required|integer|exists:master_positions,id,deleted_at,NULL',
            'kota' => 'required|integer|exists:master_cities,id'
        ]);

        if (Applicant::whereEmail($request->email)->exists())
            return $this->validationError(Lang::get('The email has already been taken.'));

        $filePath = $request->file('cv')->store('public/resumes');
        $fileUrl = url('/storage') . str_replace('public', '', $filePath);

        DB::beginTransaction();
        try {
            $applicant = new Applicant;
            $applicant->name = $request->nama;
            $applicant->email = $request->email;
            $applicant->phone_number = $request->nomor_telepon;
            $applicant->resume = $fileUrl;
            $applicant->resume_source_id = $request->sumber_cv;
            $applicant->position_id = $request->jabatan;
            $applicant->city_id = $request->kota;
            $applicant->status = 'Pending';
            $applicant->save();

            $applicantStatus = new ApplicantStatus;
            $applicantStatus->applicant_id = $applicant->id;
            $applicantStatus->status = 'Pending';
            $applicantStatus->at = now();
            $applicantStatus->by = Auth::user()->id;
            $applicantStatus->note = $request->catatan;
            $applicantStatus->save();
        } catch (Exception $e) {
            DB::rollBack();
            report($e);
            return abort(500);
        }
        DB::commit();

        $message = Lang::get('Recruitment') . ' \'' . $applicant->name . '\' ' . Lang::get('successfully created.');
        return redirect()->route('recruitment.index')->with('status', $message);
    }

    public function show($id)
    {
        if (!Laratrust::isAbleTo('view-recruitment')) return abort(404);

        $applicant = Applicant::select('applicants.id', 'applicants.name', 'applicants.email','applicants.phone_number', 'applicants.resume', 'master_resume_sources.name AS resume_source', 'master_positions.name AS position', 'master_cities.name AS city', 'applicants.interview_at', 'applicants.status')
                ->leftJoin('master_resume_sources', 'master_resume_sources.id', '=', 'applicants.resume_source_id')
                ->leftJoin('master_positions', 'master_positions.id', '=', 'applicants.position_id')
                ->leftJoin('master_cities', 'master_cities.id', '=', 'applicants.city_id')
                ->findOrFail($id);
        $applicantStatus = ApplicantStatus::select('applicant_status.status', 'applicant_status.at', 'applicant_status.note', 'users.id AS user_id', 'users.name AS user_name')
                ->leftJoin('users', 'users.id', '=', 'applicant_status.by')
                ->whereApplicantId($id)
                ->orderBy('applicant_status.at')
                ->get();
        $fileTypes = FileType::select('id', 'name')->orderBy('name')->get();

        return view('employee.recruitment.show', compact('applicant', 'applicantStatus', 'fileTypes'));
    }

    public function getFileData($id)
    {
        if (!Laratrust::isAbleTo('view-recruitment')) return abort(404);

        $applicantFiles = ApplicantFile::select('applicant_files.id', 'applicant_files.applicant_id', 'master_file_types.name AS file_type', 'applicant_files.url', 'users.name AS by', 'applicant_files.created_at')
                ->leftJoin('master_file_types', 'master_file_types.id', '=', 'applicant_files.file_type_id')
                ->leftJoin('users', 'users.id', '=', 'applicant_files.by')
                ->where('applicant_files.applicant_id', $id);

        return DataTables::of($applicantFiles)
            ->editColumn('created_at', function($applicantFile) {
                return $applicantFile->created_at->format('d-m-Y, H:i');
            })
            ->addColumn('action', function($applicantFile) {
                $view = '<a href="' . $applicantFile->url . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('View') . '" target="_blank"><i class="la la-eye"></i></a>';
                $delete = '<a href="#" data-href="' . route('recruitment.file.destroy', [$applicantFile->applicant_id, $applicantFile->id]) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Delete') . '" data-toggle="modal" data-target="#modal-delete-file" data-key="' . $applicantFile->file_type . '"><i class="la la-trash"></i></a>';

                return $view . (Laratrust::isAbleTo('validate-recruitment') ? $delete : '') ;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function edit($id)
    {
        if (!Laratrust::isAbleTo('update-recruitment')) return abort(404);

        $applicant = Applicant::select('id', 'name', 'email', 'phone_number' ,'resume', 'resume_source_id', 'position_id', 'city_id', 'status')->findOrFail($id);

        if ($applicant->status != 'Pending') {
            $message = Lang::get('Recruitment') . ' \'' . $applicant->name . '\' ' . Lang::get('cannot be edited.');
            return redirect()->route('recruitment.index')->withErrors($message);
        }

        $resumeSources = ResumeSource::select('id', 'name')->orderBy('name')->get();
        $positions = Position::select('id', 'name')->orderBy('name')->get();
        $cities = City::select('id', 'name')->orderBy('name')->get();
        $applicantStatus = ApplicantStatus::select('note')->whereApplicantId($id)->whereStatus('Pending')->first();

        return view('employee.recruitment.edit', compact('applicant', 'resumeSources', 'positions', 'cities', 'applicantStatus'));
    }

    public function update($id, Request $request)
    {
        if (!Laratrust::isAbleTo('update-recruitment')) return abort(404);

        $applicant = Applicant::findOrFail($id);

        if ($applicant->status != 'Pending') {
            $message = Lang::get('Recruitment') . ' \'' . $applicant->name . '\' ' . Lang::get('cannot be edited.');
            return redirect()->route('recruitment.index')->withErrors($message);
        }

        $this->validate($request, [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'nomor_telepon' => 'nullable|numeric|digits_between:11,15',
            'cv' => 'nullable|file|mimetypes:application/pdf',
            'sumber_cv' => 'required|integer|exists:master_resume_sources,id,deleted_at,NULL',
            'jabatan' => 'required|integer|exists:master_positions,id,deleted_at,NULL',
            'kota' => 'required|integer|exists:master_cities,id'
        ]);

        if (Applicant::whereEmail($request->email)->where('id', '<>', $id)->exists())
            return $this->validationError(Lang::get('The email has already been taken.'));

        DB::beginTransaction();
        try {
            if ($request->cv) {
                Storage::delete(str_replace(url('/storage'), 'public', $applicant->resume));

                $filePath = $request->file('cv')->store('public/resumes');
                $fileUrl = url('/storage') . str_replace('public', '', $filePath);

                $applicant->resume = $fileUrl;
            }

            $applicant->name = $request->nama;
            $applicant->email = $request->email;
            $applicant->phone_number = $request->nomor_telepon;
            $applicant->resume_source_id = $request->sumber_cv;
            $applicant->position_id = $request->jabatan;
            $applicant->city_id = $request->kota;
            $applicant->save();

            $applicantStatus = ApplicantStatus::whereApplicantId($id)->whereStatus('Pending')->first();
            $applicantStatus->note = $request->catatan;
            $applicantStatus->save();
        } catch (Exception $e) {
            DB::rollBack();
            report($e);
            return abort(500);
        }
        DB::commit();

        $message = Lang::get('Recruitment') . ' \'' . $applicant->name . '\' ' . Lang::get('successfully updated.');
        return redirect()->route('recruitment.index')->with('status', $message);
    }

    public function destroy($id)
    {
        if (!Laratrust::isAbleTo('delete-recruitment')) return abort(404);

        $applicant = Applicant::findOrFail($id);

        if ($applicant->status != 'Pending') {
            $message = Lang::get('Recruitment') . ' \'' . $applicant->name . '\' ' . Lang::get('cannot be deleted.');
            return redirect()->route('recruitment.index')->withErrors($message);
        }

        Storage::delete(str_replace(url('/storage'), 'public', $applicant->resume));
        $name = $applicant->name;
        $applicant->delete();

        $message = Lang::get('Recruitment') . ' \'' . $name . '\' ' . Lang::get('successfully deleted.');
        return redirect()->route('recruitment.index')->with('status', $message);
    }

    public function verify($id, $type, Request $request)
    {
        if (!Laratrust::isAbleTo('verify-recruitment')) return abort(404);

        $applicant = Applicant::findOrFail($id);

        if ($applicant->status != 'Pending') {
            $message = Lang::get('Recruitment') . ' \'' . $applicant->name . '\' ' . Lang::get('cannot be verified.');
            return redirect()->route('recruitment.index')->withErrors($message);
        }

        $newStatus = $type == '0' ? 'Not Qualified' : 'Qualified';
        $this->updateApplicantStatus($applicant, $newStatus, $request->catatan, $request);

        $message = Lang::get('Recruitment') . ' \'' . $applicant->name . '\' ' . Lang::get('successfully verified.');
        return redirect()->route('recruitment.index')->with('status', $message);
    }

    public function cancel($id, Request $request)
    {
        if (!Laratrust::isAbleTo('cancel-recruitment')) return abort(404);

        $applicant = Applicant::findOrFail($id);

        if ($applicant->status != 'Qualified' && $applicant->status != 'Scheduled' && $applicant->status != 'Passed') {
            $message = Lang::get('Recruitment') . ' \'' . $applicant->name . '\' ' . Lang::get('cannot be canceled.');
            return redirect()->route('recruitment.index')->withErrors($message);
        }

        $this->validate($request, [
            'alasan' => 'required|string|max:255'
        ]);

        $this->updateApplicantStatus($applicant, 'Canceled', $request->alasan, $request);

        $message = Lang::get('Recruitment') . ' \'' . $applicant->name . '\' ' . Lang::get('successfully canceled.');
        return redirect()->route('recruitment.index')->with('status', $message);
    }

    public function schedule($id, Request $request)
    {
        if (!Laratrust::isAbleTo('create-schedule-recruitment')) return abort(404);

        $applicant = Applicant::findOrFail($id);

        if ($applicant->status != 'Qualified' && $applicant->status != 'Scheduled') {
            $message = Lang::get('Recruitment') . ' \'' . $applicant->name . '\' ' . Lang::get('cannot be scheduled.');
            return redirect()->route('recruitment.index')->withErrors($message);
        }

        $this->validate($request, [
            'tanggal' => 'required|date_format:d-m-Y',
            'waktu' => 'required|date_format:H:i'
        ]);

        $this->updateApplicantStatus($applicant, 'Scheduled', $request->catatan, $request);

        $message = Lang::get('Recruitment') . ' \'' . $applicant->name . '\' ' . Lang::get('successfully scheduled.');
        return redirect()->route('recruitment.index')->with('status', $message);
    }

    public function validation($id, $type, Request $request)
    {
        if (!Laratrust::isAbleTo('validate-recruitment')) return abort(404);

        $applicant = Applicant::findOrFail($id);

        if ($applicant->status != 'Scheduled') {
            $message = Lang::get('Recruitment') . ' \'' . $applicant->name . '\' ' . Lang::get('cannot be validated.');
            return redirect()->route('recruitment.index')->withErrors($message);
        }

        $this->uploadMultipleFiles($request, $applicant);

        $newStatus = $type == '0' ? 'Not Passed' : 'Passed';
        $this->updateApplicantStatus($applicant, $newStatus, $request->catatan , $request);

        $message = Lang::get('Recruitment') . ' \'' . $applicant->name . '\' ' . Lang::get('successfully validated.');
        return redirect()->route('recruitment.index')->with('status', $message);
    }

    private function updateApplicantStatus($applicant, $newStatus, $note, $request) {
        DB::beginTransaction();
        try {
            $applicant->status = $newStatus;
            $applicant->interview_at = $request->tanggal && $request->waktu
                                        ? Carbon::parse($request->tanggal . ' ' . $request->waktu)
                                        : $applicant->interview_at;
            $applicant->save();

            $applicantStatus = new ApplicantStatus;
            $applicantStatus->applicant_id = $applicant->id;
            $applicantStatus->status = $newStatus;
            $applicantStatus->at = now();
            $applicantStatus->by = Auth::user()->id;
            $applicantStatus->note = $note;
            $applicantStatus->save();
        } catch (Exception $e) {
            DB::rollBack();
            report($e);
            return abort(500);
        }
        DB::commit();

        return;
    }

    public function storeFile($id, Request $request)
    {
        if (!Laratrust::isAbleTo('view-recruitment')) return abort(404);

        $applicant = Applicant::findOrFail($id);

        $this->uploadMultipleFiles($request, $applicant);

        $message = Lang::get('Files successfully added.');
        return redirect()->route('recruitment.show', $applicant->id)->with('status', $message);
    }

    private function uploadMultipleFiles($request, $applicant) {
        $rules = [
            'file.*' => ['required', 'file', 'mimetypes:application/pdf,image*'],
            'jenis_file.*' => ['required', 'integer', 'exists:master_file_types,id,deleted_at,NULL'],
        ];
        $this->validate($request, $rules);

        foreach ($request->file('file', []) as $i => $file) {
            $filePath = $file->store('public/applicants/files');
            $fileUrl = url('/storage') . str_replace('public', '', $filePath);

            $applicantFile = New ApplicantFile;
            $applicantFile->applicant_id = $applicant->id;
            $applicantFile->file_type_id = $request->jenis_file[$i];
            $applicantFile->url = $fileUrl;
            $applicantFile->by = Auth::user()->id;
            $applicantFile->save();
        }

        return;
    }

    public function destroyFile($id, $fileId)
    {
        if (!Laratrust::isAbleTo('validate-recruitment')) return abort(404);

        $applicant = Applicant::findOrFail($id);

        $applicantFile = ApplicantFile::whereApplicantId($id)->findOrFail($fileId);
        Storage::delete(str_replace(url('/storage'), 'public', $applicantFile->url));
        $applicantFile->delete();

        $message = Lang::get('File successfully deleted.');
        return redirect()->route('recruitment.show', $applicant->id)->with('status', $message);
    }
}
