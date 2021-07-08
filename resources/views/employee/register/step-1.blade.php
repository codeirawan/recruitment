@extends('employee.register.layout')

@section('title')
    {{ __('Applicant Form') }} | {{ config('app.name') }}
@endsection

@section('style')
    <link href="{{ asset(mix('css/form/wizard.css')) }}" rel="stylesheet">
@endsection

@section('subheader')
    {{ __('Applicant Form') }}
@endsection

@section('content')
<div class="kt-portlet">
    <div class="kt-portlet__body kt-portlet__body--fit">
        <div class="kt-grid kt-grid--desktop-xl kt-grid--ver-desktop-xl  kt-wizard-v1" id="kt_wizard_v1" data-ktwizard-state="step-first">
            <div class="kt-grid__item kt-wizard-v1__aside">
                <div class="kt-wizard-v1__nav">
                    @include('employee.register.inc.wizard')

                    <div class="kt-wizard-v1__nav-details">
                        <div class="kt-wizard-v1__nav-item-wrapper" data-ktwizard-type="step-info" data-ktwizard-state="current">
                            <div class="kt-wizard-v1__nav-item-title">{{ __('Personal Data') }}</div>
                            <div class="kt-wizard-v1__nav-item-desc">{{ __('This form must be filled in completely. Incomplete filling will affect the processing of your application.')}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">
                <form class="kt-form" id="kt_form_1" action="{{ route('recruitment.register.step-1.validate', $id) }}" method="POST">
                    @csrf
                    
                    <div class="kt-wizard-v1__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                        <div class="kt-separator kt-separator--height-xs"></div>
                        <div class="kt-form__section kt-form__section--first" class="form-inline justify-content-center">
                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    @include('layouts.inc.alert')
                                    <label for="jabatan_yang_dilamar">{{ __('Applied Position') }}</label>
                                    <select id="jabatan_yang_dilamar" name="jabatan_yang_dilamar" class="form-control kt_selectpicker @error('jabatan_yang_dilamar') is-invalid @enderror" data-live-search="true" title="{{ __('Choose') }} {{ __('Position') }}" required>
                                        @foreach ($positions as $position)
                                            <option value="{{ $position->id }}" {{ old('jabatan_yang_dilamar', $data['jabatan_yang_dilamar']) == $position->id ? 'selected' : '' }}>{{ $position->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('jabatan_yang_dilamar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-4">
                                    <label for="nama_lengkap">{{ __('Full Name') }}</label>
                                    <input id="nama_lengkap" type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap" value="{{ old('nama_lengkap', $data['nama_lengkap']) }}" required>

                                    @error('nama_lengkap')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="nama_panggilan">{{ __('Nickname') }}</label>
                                    <input id="nama_panggilan" type="text" class="form-control @error('nama_panggilan') is-invalid @enderror" name="nama_panggilan" value="{{ old('nama_panggilan', $data['nama_panggilan']) }}">

                                    @error('nama_panggilan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-4">
                                    <label for="email">{{ __('Email') }}</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $data['email']) }}">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="nomor_telepon">{{ __('Phone Number') }}</label>
                                    <input id="nomor_telepon" type="text" class="form-control @error('nomor_telepon') is-invalid @enderror" name="nomor_telepon" value="{{ old('nomor_telepon', $data['nomor_telepon']) }}">

                                    @error('nomor_telepon')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-4">
                                    <label for="status_pernikahan">{{ __('Marital Status') }}</label>
                                    <select class="form-control @error('status_pernikahan') is-invalid @enderror" id="status_pernikahan" name="status_pernikahan">
                                        <option value="Single" {{ old('status_pernikahan', $data['status_pernikahan']) == 'Single' ? 'selected' : '' }}>{{ __('Single') }}</option>
                                        <option value="Married" {{ old('status_pernikahan', $data['status_pernikahan']) == 'Married' ? 'selected' : '' }}>{{ __('Married') }}</option>
                                        <option value="Divorcee" {{ old('status_pernikahan', $data['status_pernikahan']) == 'Divorcee' ? 'selected' : '' }}>{{ __('Divorcee') }}</option>
                                    </select>
                                </div>

                                @error('status_pernikahan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <div class="form-group col-lg-4">
                                    <label for="status_tempat_tinggal">{{ __('Status of Residence') }}</label>
                                    <select class="form-control @error('status_tempat_tinggal') is-invalid @enderror" id="status_tempat_tinggal" name="status_tempat_tinggal">
                                        <option value="Rent" {{ old('status_tempat_tinggal', $data['status_tempat_tinggal']) == 'Rent' ? 'selected' : '' }}>{{ __('Boarding House / Rented House') }}</option>
                                        <option value="Parent" {{ old('status_tempat_tinggal', $data['status_tempat_tinggal']) == 'Parent' ? 'selected' : '' }}>{{ __('With Parent') }}</option>
                                        <option value="Own" {{ old('status_tempat_tinggal', $data['status_tempat_tinggal']) == 'Own' ? 'selected' : '' }}>{{ __('Own') }}</option>
                                    </select>
                                </div>

                                @error('status_tempat_tinggal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-4">
                                    <label for="alamat_domisili">{{ __('Residence Address') }}</label>
                                    <textarea id="alamat_domisili" name="alamat_domisili" rows="3" class="form-control @error('alamat_domisili') is-invalid @enderror">{{ old('alamat_domisili', $data['alamat_domisili']) }}</textarea>

                                    @error('alamat_domisili')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="kota_domisili">{{ __('City / Regency of Residence') }}</label>
                                    <select id="kota_domisili" name="kota_domisili" class="form-control kt_selectpicker @error('kota_domisili') is-invalid @enderror" data-live-search="true" title="{{ __('Choose') }} {{ __('City') }} / {{ __('Regency') }}">
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" {{ old('kota_domisili', $data['kota_domisili']) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('kota_domisili')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-4">
                                    <label for="kode_pos_domisili">{{ __('Postal Code of Residence') }}</label>
                                    <input id="kode_pos_domisili" type="text" class="form-control @error('kode_pos_domisili') is-invalid @enderror" name="kode_pos_domisili" value="{{ old('kode_pos_domisili', $data['kode_pos_domisili']) }}">

                                    @error('kode_pos_domisili')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="nomor_telepon_domisili">{{ __('Telephone Number of Residence') }}</label>
                                    <input id="nomor_telepon_domisili" type="text" class="form-control @error('nomor_telepon_domisili') is-invalid @enderror" name="nomor_telepon_domisili" value="{{ old('nomor_telepon_domisili', $data['nomor_telepon_domisili']) }}">

                                    @error('nomor_telepon_domisili')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-4">
                                    <label for="alamat_rumah">{{ __('Home Address') }}</label>
                                    <textarea id="alamat_rumah" name="alamat_rumah" rows="3" class="form-control @error('alamat_rumah') is-invalid @enderror">{{ old('alamat_rumah', $data['alamat_rumah']) }}</textarea>

                                    @error('alamat_rumah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="kota_asal">{{ __('Home City / Regency') }}</label>
                                    <select id="kota_asal" name="kota_asal" class="form-control kt_selectpicker @error('kota_asal') is-invalid @enderror" data-live-search="true" title="{{ __('Choose') }} {{ __('City') }} / {{ __('Regency') }}">
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" {{ old('kota_asal', $data['kota_asal']) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('kota_asal')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-4">
                                    <label for="kode_pos_rumah">{{ __('Home Postal Code') }}</label>
                                    <input id="kode_pos_rumah" type="text" class="form-control @error('kode_pos_rumah') is-invalid @enderror" name="kode_pos_rumah" value="{{ old('kode_pos_rumah', $data['kode_pos_rumah']) }}">

                                    @error('kode_pos_rumah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="nomor_telepon_rumah">{{ __('Home Telephone Number') }}</label>
                                    <input id="nomor_telepon_rumah" type="text" class="form-control @error('nomor_telepon_rumah') is-invalid @enderror" name="nomor_telepon_rumah" value="{{ old('nomor_telepon_rumah', $data['nomor_telepon_rumah']) }}">

                                    @error('nomor_telepon_rumah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-4">
                                    <label for="tempat_lahir">{{ __('Place of Birth') }}</label>
                                    <select id="tempat_lahir" name="tempat_lahir" class="form-control kt_selectpicker @error('tempat_lahir') is-invalid @enderror" data-live-search="true" title="{{ __('Choose') }} {{ __('City') }} / {{ __('Regency') }}">
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" {{ old('tempat_lahir', $data['tempat_lahir']) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('tempat_lahir')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="tanggal_lahir">{{ __('Date of Birth') }}</label>
                                    <input id="tanggal_lahir" type="text" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{ old('tanggal_lahir', $data['tanggal_lahir']) }}" placeholder="{{ __('Select') }} {{ __('Date') }}" readonly>

                                    @error('tanggal_lahir')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-4">
                                    <label for="jenis_kelamin">{{ __('Gender') }}</label>
                                    <select class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin">
                                        <option value="Male" {{ old('jenis_kelamin', $data['jenis_kelamin']) == 'Male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                        <option value="Female" {{ old('jenis_kelamin', $data['jenis_kelamin']) == 'Female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                    </select>

                                    @error('jenis_kelamin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="golongan_darah">{{ __('Blood Type') }}</label>
                                    <select class="form-control @error('golongan_darah') is-invalid @enderror" id="golongan_darah" name="golongan_darah">
                                        <option value="A" {{ old('golongan_darah', $data['golongan_darah']) == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ old('golongan_darah', $data['golongan_darah']) == 'B' ? 'selected' : '' }}>B</option>
                                        <option value="AB" {{ old('golongan_darah', $data['golongan_darah']) == 'AB' ? 'selected' : '' }}>AB</option>
                                        <option value="O" {{ old('golongan_darah', $data['golongan_darah']) == 'O' ? 'selected' : '' }}>O</option>
                                    </select>

                                    @error('golongan_darah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-4">
                                    <label for="agama">{{ __('Religion') }}</label>
                                    <select class="form-control @error('agama') is-invalid @enderror" id="agama" name="agama">
                                        <option value="Islam" {{ old('agama', $data['agama']) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                        <option value="Christian" {{ old('agama', $data['agama']) == 'Christian' ? 'selected' : '' }}>{{ __('Christian') }}</option>
                                        <option value="Catholic" {{ old('agama', $data['agama']) == 'Catholic' ? 'selected' : '' }}>{{ __('Catholic') }}</option>
                                        <option value="Hinduism" {{ old('agama', $data['agama']) == 'Hinduism' ? 'selected' : '' }}>{{ __('Hinduism') }}</option>
                                        <option value="Buddhism" {{ old('agama', $data['agama']) == 'Buddhism' ? 'selected' : '' }}>{{ __('Buddhism') }}</option>
                                        <option value="Confucianism" {{ old('agama', $data['agama']) == 'Confucianism' ? 'selected' : '' }}>{{ __('Confucianism') }}</option>
                                        <option value="Other" {{ old('agama', $data['agama']) == 'Other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                    </select>

                                    @error('agama')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="kebangsaan">{{ __('Nationality') }}</label>
                                    <input id="kebangsaan" type="text" class="form-control @error('kebangsaan') is-invalid @enderror" name="kebangsaan" value="{{ old('kebangsaan', $data['kebangsaan']) }}">

                                    @error('kebangsaan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-4">
                                    <label for="nomor_ktp">{{ __('Identity Card Number') }}</label>
                                    <input id="nomor_ktp" type="text" class="form-control @error('nomor_ktp') is-invalid @enderror" name="nomor_ktp" value="{{ old('nomor_ktp', $data['nomor_ktp']) }}">

                                    @error('nomor_ktp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="nomor_sim">{{ __('Driving License Number') }}</label>
                                    <input id="nomor_sim" type="text" class="form-control @error('nomor_sim') is-invalid @enderror" name="nomor_sim" value="{{ old('nomor_sim', $data['nomor_sim']) }}">

                                    @error('nomor_sim')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <label for="npwp">NPWP</label>
                                    <input id="npwp" type="text" class="form-control @error('npwp') is-invalid @enderror" name="npwp" value="{{ old('npwp', $data['npwp']) }}">

                                    @error('npwp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-4">
                                    <label for="kendaraan">{{ __('Vehicle') }}</label>
                                    <select class="form-control @error('kendaraan') is-invalid @enderror" id="kendaraan" name="kendaraan">
                                        <option value="Own" {{ old('kendaraan', $data['kendaraan']) == 'Own' ? 'selected' : '' }}>{{ __('Own') }}</option>
                                        <option value="Parent" {{ old('kendaraan', $data['kendaraan']) == 'Parent' ? 'selected' : '' }}>{{ __('Parent') }}</option>
                                        <option value="Office" {{ old('kendaraan', $data['kendaraan']) == 'Office' ? 'selected' : '' }}>{{ __('Office') }}</option>
                                        <option value="Other" {{ old('kendaraan', $data['kendaraan']) == 'Other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                    </select>

                                    @error('kendaraan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="jenis_kendaraan">{{ __('Vehicle Type') }}</label>
                                    <input id="jenis_kendaraan" type="text" class="form-control @error('jenis_kendaraan') is-invalid @enderror" name="jenis_kendaraan" value="{{ old('jenis_kendaraan', $data['jenis_kendaraan']) }}">

                                    @error('jenis_kendaraan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group col-lg-8">
                            <div class="kt-form__actions">
                                <button type="submit" class="btn btn-brand btn-md btn-tall btn-wide btn-bold btn-upper" data-ktwizard-type="action-next">{{ __('Next Step') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ asset(mix('js/form/validation.js')) }}"></script>
    <script type="text/javascript">
        $('.kt_selectpicker').selectpicker({
            noneResultsText: "{{ __('No matching results for') }} {0}"
        });

        $('#tanggal_lahir').datepicker({
            autoclose: true,
            clearBtn: true,
            disableTouchKeyboard: true,
            format: "dd-mm-yyyy",
            language: "{{ config('app.locale') }}",
            endDate: "-1d",
            templates: {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            },
            todayBtn: "linked",
            todayHighlight: true
        });
    </script>
@endsection