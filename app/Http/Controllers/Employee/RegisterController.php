<?php

namespace App\Http\Controllers\Employee;

use Laratrust, Lang;
use App\Models\Master\City;
use Illuminate\Http\Request;
use App\Models\Master\Position;
use App\Models\Employee\Applicant;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function showStepOneForm($id)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);
        $positions = Position::select('id', 'name')->orderBy('name')->get();
        $cities = City::select('id', 'name')->orderBy('name')->get();

        $data = session()->has('employee_registration_step_1') ? session()->get('employee_registration_step_1') : null;

        return view('employee.register.step-1', compact('id', 'data', 'positions', 'cities'));
    }

    public function validateStepOne($id, Request $request)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        $this->validate($request, [
            'jabatan_yang_dilamar' => ['required', 'integer', 'exists:master_positions,id,deleted_at,NULL'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nama_panggilan' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'nomor_telepon' => ['nullable', 'numeric'],
            'status_pernikahan' => ['nullable', 'in:Single,Married,Divorcee'],
            'status_tempat_tinggal' => ['nullable', 'in:Rent,Parent,Own'],
            'alamat_domisili' => ['nullable', 'string', 'max:255'],
            'kota_domisili' => ['nullable', 'integer' ,'exists:master_cities,id'],
            'kode_pos_domisili' => ['nullable', 'numeric'],
            'nomor_telepon_domisili' => ['nullable', 'numeric'],
            'alamat_rumah' => ['nullable', 'string', 'max:255'],
            'kota_asal' => ['nullable', 'integer' ,'exists:master_cities,id'],
            'kode_pos_rumah' => ['nullable', 'numeric'],
            'nomor_telepon_rumah' => ['nullable', 'numeric'],
            'tempat_lahir' => ['nullable', 'integer' ,'exists:master_cities,id'],
            'tanggal_lahir' => ['nullable', 'date_format:d-m-Y'],
            'jenis_kelamin' => ['nullable', 'in:Male,Female'],
            'golongan_darah' => ['nullable', 'in:A,B,AB,O'],
            'agama' => ['nullable', 'in:Islam,Christian,Catholic,Hinduism,Buddhism,Confucianism,Other'],
            'kebangsaan' => ['nullable', 'string', 'max:255'],
            'nomor_ktp' => ['nullable', 'numeric'],
            'nomor_sim' => ['nullable', 'numeric'],
            'npwp' => ['nullable', 'numeric'],
            'kendaraan' => ['nullable', 'in:Own,Office,Parent,Other'],
            'jenis_kendaraan' => ['nullable', 'string', 'max:255'],
        ]);

        if (Applicant::whereEmail($request->email)->where('id', '<>', $applicantId)->exists())
            return $this->validationError(Lang::get('The email has already been taken.'));

        $request->session()->put('employee_registration_step_1', $request->all());

        return redirect()->route('recruitment.register.step-2', $id);
    }

    public function showStepTwoForm($id)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        if (!session()->has('employee_registration_step_1')) return redirect()->route('recruitment.register.step-1', $id);

        $data = session()->get('employee_registration_step_2') ? session()->get('employee_registration_step_2') : null;
        $dataStepOne = session()->get('employee_registration_step_1');
        
        return view('employee.register.step-2', compact('id', 'data', 'dataStepOne'));
        
    }

    public function validateStepTwo($id, Request $request)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);
        
        $this->validate($request, [
            'nama_ayah' => ['nullable', 'string', 'max:255'],
            'usia_ayah' => ['nullable', 'numeric'],
            'pendidikan_terakhir_ayah' => ['nullable', 'in:Doctor,Master,Bachelor,Diploma,Senior High School,Junior High School,Elementary School,Other'],
            'jabatan_terakhir_ayah' => ['nullable', 'string', 'max:255'],
            'perusahaan_ayah' => ['nullable', 'string', 'max:255'],
            'keterangan_ayah' => ['nullable', 'string', 'max:255'],
            
            'nama_ibu' => ['nullable', 'string', 'max:255'],
            'usia_ibu' => ['nullable', 'numeric'],
            'pendidikan_terakhir_ibu' => ['nullable', 'in:Doctor,Master,Bachelor,Diploma,Senior High School,Junior High School,Elementary School,Other'],
            'jabatan_terakhir_ibu' => ['nullable', 'string', 'max:255'],
            'perusahaan_ibu' => ['nullable', 'string', 'max:255'],
            'keterangan_ibu' => ['nullable', 'string', 'max:255'],
            
            'saudara.*' => ['nullable'],
            'nama_saudara.*' => ['nullable', 'string', 'max:255'],
            'usia_suadara.*' => ['nullable', 'numeric'],
            'jenis_kelamin_saudara.*' => ['nullable', 'in:Male,Female'],
            'pendidikan_terakhir_suadara.*' => ['nullable', 'in:Doctor,Master,Bachelor,Diploma,Senior High School,Junior High School,Elementary School,Other'],
            'jabatan_terakhir_saudara.*' => ['nullable', 'string', 'max:255'],
            'perusahaan_saudara.*' => ['nullable', 'string', 'max:255'],
            'keterangan_saudara.*' => ['nullable', 'string', 'max:255'],
            
            'nama_suami' => ['nullable', 'string', 'max:255'],
            'usia_suami' => ['nullable', 'numeric'],
            'pendidikan_terakhir_suami' => ['nullable', 'in:Doctor,Master,Bachelor,Diploma,Senior High School,Junior High School,Elementary School,Other'],
            'jabatan_terakhir_suami' => ['nullable', 'string', 'max:255'],
            'perusahaan_suami' => ['nullable', 'string', 'max:255'],
            'keterangan_suami' => ['nullable', 'string', 'max:255'],
            
            'nama_istri' => ['nullable', 'string', 'max:255'],
            'usia_istri' => ['nullable', 'numeric'],
            'pendidikan_terakhir_istri' => ['nullable', 'in:Doctor,Master,Bachelor,Diploma,Senior High School,Junior High School,Elementary School,Other'],
            'jabatan_terakhir_istri' => ['nullable', 'string', 'max:255'],
            'perusahaan_istri' => ['nullable', 'string', 'max:255'],
            'keterangan_istri' => ['nullable', 'string', 'max:255'],
            
            'anak.*' => ['nullable'],
            'nama_anak.*' =>['nullable', 'string', 'max:255'],
            'usia_anak.*' => ['nullable', 'numeric'],
            'jenis_kelamin_anak.*' => ['nullable', 'in:Male,Female'],
            'pendidikan_terakhir_anak.*' => ['nullable', 'in:Doctor,Master,Bachelor,Diploma,Senior High School,Junior High School,Elementary School,Other'],
            'jabatan_terakhir_anak.*' => ['nullable', 'string', 'max:255'],
            'perusahaan_anak.*' => ['nullable', 'string', 'max:255'],
            'keterangan_anak.*' => ['nullable', 'string', 'max:255'],
        ]);

        $request->session()->put('employee_registration_step_2', $request->all());
    
        return redirect()->route('recruitment.register.step-3', $id);
     
    }

    public function showStepThreeForm($id)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);
        $cities = City::select('id', 'name')->orderBy('name')->get();
        
        if (!session()->has('employee_registration_step_2')) return redirect()->route('recruitment.register.step-2', $id);

        $data = session()->has('employee_registration_step_3') ? session()->get('employee_registration_step_3') : null;
        
        return view('employee.register.step-3', compact('id', 'data', 'cities'));
    }

    public function validateStepThree($id, Request $request)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        $this->validate($request, [
            'nama_sd' => ['nullable', 'string', 'max:255'],
            'kota_sd' => ['nullable', 'integer' ,'exists:master_cities,id'],
            'tahun_masuk_sd' => ['nullable', 'numeric', 'digits_between:0,4'],
            'tahun_keluar_sd' => ['nullable', 'numeric', 'digits_between:0,4'],
            'lulus_sd' => ['nullable'],

            'nama_smp' => ['nullable', 'string', 'max:255'],
            'kota_smp' => ['nullable', 'integer' ,'exists:master_cities,id'],
            'tahun_masuk_smp' => ['nullable', 'numeric', 'digits_between:0,4'],
            'tahun_keluar_smp' => ['nullable', 'numeric', 'digits_between:0,4'],
            'lulus_smp' => ['nullable'],

            'nama_sma' => ['nullable', 'string', 'max:255'],
            'kota_sma' => ['nullable', 'integer' ,'exists:master_cities,id'],
            'jurusan_sma' => ['nullable', 'string', 'max:255'],
            'tahun_masuk_sma' => ['nullable', 'numeric', 'digits_between:0,4'],
            'tahun_keluar_sma' => ['nullable', 'numeric', 'digits_between:0,4'],
            'lulus_sma' => ['nullable'],

            'nama_kampus' => ['nullable', 'string', 'max:255'],
            'kota_kampus' => ['nullable', 'integer' ,'exists:master_cities,id'],
            'jurusan_kuliah' => ['nullable', 'string', 'max:255'],
            'tahun_masuk_kuliah' => ['nullable', 'numeric', 'digits_between:0,4'],
            'tahun_keluar_kuliah' => ['nullable', 'numeric', 'digits_between:0,4'],
            'lulus_kuliah' => ['nullable'],

            'nama_lanjutan' => ['nullable', 'string', 'max:255'],
            'kota_lanjutan' => ['nullable', 'integer' ,'exists:master_cities,id'],
            'jurusan_lanjutan' => ['nullable', 'string', 'max:255'],
            'tahun_masuk_lanjutan' => ['nullable', 'numeric', 'digits_between:0,4'],
            'tahun_keluar_lanjutan' => ['nullable', 'numeric', 'digits_between:0,4'],
            'lulus_lanjutan' => ['nullable'],
        ]);

        $request->session()->put('employee_registration_step_3', $request->all());
        
        return redirect()->route('recruitment.register.step-4', $id);
    }

    public function showStepFourForm($id)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);
        $cities = City::select('id', 'name')->orderBy('name')->get();

        if (!session()->has('employee_registration_step_3')) return redirect()->route('recruitment.register.step-3', $id);

        $data = session()->has('employee_registration_step_4') ? session()->get('employee_registration_step_4') : null;
        if (session()->has('employee_registration_step_4')) return DataTables::of($data);
        return view('employee.register.step-4', compact('id', 'data', 'cities'));
    }

    public function validateStepFour($id, Request $request)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        $this->validate($request, [
            'kursus.*' => ['nullable', 'string', 'max:255'],
            'kursus.*.bidang' => ['nullable', 'string', 'max:255'],
            'kursus.*.lembaga' => ['nullable', 'string', 'max:255'],
            'kursus.*.kota' => ['nullable', 'string' ,'exists:master_cities,name'],
            'kursus.*.lama_kursus' => ['nullable', 'string', 'max:255'],
            'kursus.*.tahun' => ['nullable', 'numeric'],
            'kursus.*.dibiayai_oleh' => ['nullable', 'string', 'max:255'],
        ]);

        $request->session()->put('employee_registration_step_4', $request->all());
        
        return redirect()->route('recruitment.register.step-5', $id);
    }

    public function showStepFiveForm($id)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        if (!session()->has('employee_registration_step_4')) return redirect()->route('recruitment.register.step-4', $id);

        $data = session()->has('employee_registration_step_5') ? session()->get('employee_registration_step_5') : null;

        return view('employee.register.step-5', compact('id', 'data'));
    }

    public function validateStepFive($id, Request $request)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        $this->validate($request, [
            'bahasa.*.bahasa' => ['nullable', 'string', 'max:255'],
            'bahasa.*.bicara' => ['nullable', 'in:Good,Enough,Less'],
            'bahasa.*.mendengar' => ['nullable', 'in:Good,Enough,Less'],
            'bahasa.*.membaca' => ['nullable', 'in:Good,Enough,Less'],
            'bahasa.*.menulis' => ['nullable', 'in:Good,Enough,Less'],
            'bahasa.*.pemakaian' => ['nullable', 'in:Active,Passive'],
        ]);
        
        $request->session()->put('employee_registration_step_5', $request->all());

        return redirect()->route('recruitment.register.step-6', $id);
    }

    public function showStepSixForm($id)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        if (!session()->has('employee_registration_step_5')) return redirect()->route('recruitment.register.step-5', $id);

        $data = session()->has('employee_registration_step_6') ? session()->get('employee_registration_step_6') : null;

        return view('employee.register.step-6', compact('id', 'data'));
    }

    public function validateStepSix($id, Request $request)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        $this->validate($request, [
            'organisasi.*.tahun' => ['nullable', 'numeric'],
            'organisasi.*.nama_organisasi' => ['nullable', 'string', 'max:255'],
            'organisasi.*.jenis_kegiatan' => ['nullable', 'string', 'max:255'],
            'organisasi.*.jabatan' => ['nullable', 'string', 'max:255'],
        ]);

        $request->session()->put('employee_registration_step_6', $request->all());

        return redirect()->route('recruitment.register.step-7', $id);
    }

    public function showStepSevenForm($id)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        if (!session()->has('employee_registration_step_6')) return redirect()->route('recruitment.register.step-6', $id);

        $data = session()->has('employee_registration_step_7') ? session()->get('employee_registration_step_7') : null;

        return view('employee.register.step-7', compact('id', 'data'));
    }

    public function validateStepSeven($id, Request $request)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        $this->validate($request, [
            'hobi' => ['nullable', 'string', 'max:255'],
        ]);

        $request->session()->put('employee_registration_step_7', $request->all());

        return redirect()->route('recruitment.register.step-8', $id);
    }

    public function showStepEightForm($id)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        if (!session()->has('employee_registration_step_7')) return redirect()->route('recruitment.register.step-7', $id);

        $data = session()->has('employee_registration_step_8') ? session()->get('employee_registration_step_8') : null;

        return view('employee.register.step-8', compact('id', 'data'));
    }

    public function validateStepEight($id, Request $request)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        $this->validate($request, [
            'jumlah_bacaan' => ['nullable', 'in:A Lot,Enough,Little'],
            'topik_bacaan' => ['nullable', 'string', 'max:255'],
            'media_bacaan' => ['nullable', 'string', 'max:255'],
        ]);

        $request->session()->put('employee_registration_step_8', $request->all());
        
        return redirect()->route('recruitment.register.step-9', $id);
    }

    public function showStepNineForm($id)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        if (!session()->has('employee_registration_step_8')) return redirect()->route('recruitment.register.step-8', $id);

        $data = session()->has('employee_registration_step_9') ? session()->get('employee_registration_step_9') : null;

        return view('employee.register.step-9', compact('id', 'data'));
    }

    public function validateStepNine($id, Request $request)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        $this->validate($request, [
            'pengalaman_kerja.*.nama_perusahaan' => ['nullable', 'string', 'max:255'],
            'pengalaman_kerja.*.jabatan_awal' => ['nullable', 'string', 'max:255'],
            'pengalaman_kerja.*.jabatan_akhir' => ['nullable', 'string', 'max:255'],
            'pengalaman_kerja.*.lama_bekerja' => ['nullable', 'numeric'],
            'pengalaman_kerja.*.jenis_usaha' => ['nullable', 'string', 'max:255'],
            'pengalaman_kerja.*.alasan_berhenti' => ['nullable', 'string', 'max:255'],
            'pengalaman_kerja.*.gaji_terakhir' => ['nullable', 'numeric'],
        ]);

        $request->session()->put('employee_registration_step_9', $request->all());
        
        return redirect()->route('recruitment.register.step-10', $id);
    }

    public function showStepTenForm($id)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        if (!session()->has('employee_registration_step_9')) return redirect()->route('recruitment.register.step-9', $id);

        $data = session()->has('employee_registration_step_10') ? session()->get('employee_registration_step_10') : null;

        return view('employee.register.step-10', compact('id', 'data'));
    }

    public function validateStepTen($id, Request $request)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        $this->validate($request, [
            'referensi.*.nama' => ['nullable', 'string', 'max:255'],
            'referensi.*.alamat' => ['nullable', 'string', 'max:255'],
            'referensi.*.nomor_telepon' => ['nullable', 'numeric'],
            'referensi.*.pekerjaan' => ['nullable', 'string', 'max:255'],
            'referensi.*.hubungan' => ['nullable', 'string', 'max:255'],
        ]);

        $request->session()->put('employee_registration_step_10', $request->all());
        
        return redirect()->route('recruitment.register.step-11', $id);
    }

    public function showStepElevenForm($id)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        if (!session()->has('employee_registration_step_10')) return redirect()->route('recruitment.register.step-10', $id);

        $data = session()->has('employee_registration_step_11') ? session()->get('employee_registration_step_11') : null;

        return view('employee.register.step-11', compact('id', 'data'));
    }

    public function validateStepEleven($id, Request $request)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        $this->validate($request, [
            'uraian_tugas' => ['nullable', 'string', 'max:255'],
        ]);

        $request->session()->put('employee_registration_step_11', $request->all());

        return redirect()->route('recruitment.register.step-12', $id);
    }

    public function showStepTwelveForm($id)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        if (!session()->has('employee_registration_step_11')) return redirect()->route('recruitment.register.step-11', $id);

        $data = session()->has('employee_registration_step_12') ? session()->get('employee_registration_step_12') : null;

        return view('employee.register.step-12', compact('id', 'data'));
    }

    public function validateStepTwelve($id, Request $request)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        $this->validate($request, [
            'hal_positif' => ['nullable', 'string', 'max:255'],
            'hal_negatif' => ['nullable', 'string', 'max:255'],
        ]);

        $request->session()->put('employee_registration_step_12', $request->all());

        return redirect()->route('recruitment.register.step-13', $id);
    }

    public function showStepThirteenForm($id)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        for ($i = 1; $i < 13; $i++) {
            if (!session()->has('employee_registration_step_'.$i))
                return redirect()->route('recruitment.register.step-'.$i, $id);
        }

        $data = session()->has('employee_registration_step_13') ? session()->get('employee_registration_step_13') : null;

        return view('employee.register.step-13', compact('id', 'data'));
    }

    public function validateStepThirteen($id, Request $request)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        $this->validate($request, [
            'lokasi' => ['required']
        ]);

        $request->session()->put('employee_registration_step_13', $request->all());

        return redirect()->route('recruitment.register.step-14', $id);
    }

    public function showStepFourteenForm($id)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        if (!session()->has('employee_registration_step_13')) return redirect()->route('recruitment.register.step-13', $id);

        $data = session()->has('employee_registration_step_14') ? session()->get('employee_registration_step_14') : null;

        return view('employee.register.step-14', compact('id', 'data'));
    }

    public function validateStepFourteen($id, Request $request)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        $this->validate($request, [

            
        ]);

        $request->session()->put('employee_registration_step_14', $request->all());

        return redirect()->route('recruitment.register.step-15', $id);
    }

    public function showStepFifteenForm($id)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        if (!session()->has('employee_registration_step_14')) return redirect()->route('recruitment.register.step-14', $id);

        $data = session()->has('employee_registration_step_15') ? session()->get('employee_registration_step_15') : null;

        return view('employee.register.step-15', compact('id', 'data'));
    }

    public function validateStepFifteen($id, Request $request)
    {
        $applicantId = $this->simpleDecrypt($id);
        $applicant = Applicant::whereStatus('Scheduled')->whereNull('register_at')->findOrFail($applicantId);

        $this->validate($request, [
            'persetujuan' => ['required']
        ]);

        $request->session()->put('employee_registration_step_15', $request->all());
        dd($request->session());
        return redirect()->route('recruitment.register.step-1', $id);
    }
}