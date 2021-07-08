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
                            <div class="kt-wizard-v1__nav-item-title">{{ __('Family Tree (Including You)') }}</div>
                            <div class="kt-wizard-v1__nav-item-desc">{{ __('This form must be filled in completely. Incomplete filling will affect the processing of your application.')}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">
                <form class="kt-form" id="kt_form_1" action="{{ route('recruitment.register.step-2.validate', $id) }}" method="POST">
                    @csrf

                    <div class="kt-wizard-v1__content" data-ktwizard-type="step-content" data-ktwizard-state="current">                                            
                        <div class="kt-separator kt-separator--height-xs"></div>
                        <div class="kt-form__section kt-form__section--first">
                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8" >
                                    @include('layouts.inc.alert')
                                    <div class="kt-heading kt-heading--md" >{{ __('Father') }}</div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-3">
                                    <label for="nama_ayah">{{ __('Name') }}</label>
                                    <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror" id="nama_ayah"  name="nama_ayah" value="{{ old('nama_ayah', $data['nama_ayah']) }}">

                                    @error('nama_ayah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="usia_ayah">{{ __('Age') }}</label>
                                    <input type="number" class="form-control @error('usia_ayah') is-invalid @enderror" id="usia_ayah" name="usia_ayah" value="{{ old('usia_ayah', $data['usia_ayah']) }}">

                                    @error('usia_ayah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-3">
                                    <label for="pendidikan_terakhir_ayah">{{ __('Last Education') }}</label>
                                    <select class="form-control @error('pendidikan_terakhir_ayah') is-invalid @enderror" id="pendidikan_terakhir_ayah" name="pendidikan_terakhir_ayah">
                                        <option value="Doctor" {{ old('pendidikan_terakhir_ayah', $data['pendidikan_terakhir_ayah']) == 'Doctor' ? 'selected' : '' }}>{{ __('Doctor') }}</option>
                                        <option value="Master" {{ old('pendidikan_terakhir_ayah', $data['pendidikan_terakhir_ayah']) == 'Master' ? 'selected' : '' }}>{{ __('Master') }}</option>
                                        <option value="Bachelor" {{ old('pendidikan_terakhir_ayah', $data['pendidikan_terakhir_ayah']) == 'Bachelor' ? 'selected' : '' }}>{{ __('Bachelor') }}</option>
                                        <option value="Diploma" {{ old('pendidikan_terakhir_ayah', $data['pendidikan_terakhir_ayah']) == 'Diploma' ? 'selected' : '' }}>{{ __('Diploma') }}</option>
                                        <option value="Senior High Schoool" {{ old('pendidikan_terakhir_ayah', $data['pendidikan_terakhir_ayah']) == 'Senior High School' ? 'selected' : '' }}>{{ __('Senior High School') }}</option>
                                        <option value="Junior High School" {{ old('pendidikan_terakhir_ayah', $data['pendidikan_terakhir_ayah']) == 'Junior High Shool' ? 'selected' : '' }}>{{ __('Junior High School') }}</option>
                                        <option value="Elementary Schoool" {{ old('pendidikan_terakhir_ayah', $data['pendidikan_terakhir_ayah']) == 'Elementary School' ? 'selected' : '' }}>{{ __('Elementary School') }}</option>
                                        <option value="Other" {{ old('pendidikan_terakhir_ayah', $data['pendidikan_terakhir_ayah']) == 'Other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                    </select>

                                    @error('pendidikan_terakhir_ayah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-3">
                                    <label for="jabatan_terakhir_ayah">{{ __('Last Position') }}</label>
                                    <input type="text" class="form-control @error('jabatan_terakhir_ayah') is-invalid @enderror" id="jabatan_terakhir_ayah" name="jabatan_terakhir_ayah" value="{{ old('jabatan_terakhir_ayah', $data['jabatan_terakhir_ayah']) }}">

                                    @error('jabatan_terakhir_ayah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-3">
                                    <label for="perusahaan_ayah">{{ __('Company') }}</label>
                                    <input type="text" class="form-control @error('perusahaan_ayah') is-invalid @enderror" id="perusahaan_ayah" name="perusahaan_ayah" value="{{ old('perusahaan_ayah', $data['perusahaan_ayah']) }}">

                                    @error('perusahaan_ayah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="keterangan_ayah">{{ __('Information') }}</label>
                                    <input type="text" class="form-control @error('keterangan_ayah') is-invalid @enderror" id="keterangan_ayah" name="keterangan_ayah" value="{{ old('keterangan_ayah', $data['keterangan_ayah']) }}">

                                    @error('keterangan_ayah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8" >
                                    <div class="kt-heading kt-heading--md" >{{ __('Mother') }}</div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-3">
                                    <label for="nama_ibu">{{ __('Name') }}</label>
                                    <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror" id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu', $data['nama_ibu']) }}">

                                    @error('nama_ibu')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="usia_ibu">{{ __('Age') }}</label>
                                    <input type="number" class="form-control @error('usia_ibu') is-invalid @enderror" id="usia_ibu" name="usia_ibu" value="{{ old('usia_ibu', $data['usia_ibu']) }}">

                                    @error('usia_ibu')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-3">
                                    <label for="pendidikan_terakhir_ibu">{{ __('Last Education') }}</label>
                                    <select class="form-control @error('pendidikan_terakhir_ibu') is-invalid @enderror" id="pendidikan_terakhir_ibu" name="pendidikan_terakhir_ibu">
                                        <option value="Doctor" {{ old('pendidikan_terakhir_ibu', $data['pendidikan_terakhir_ibu']) == 'Doctor' ? 'selected' : '' }}>{{ __('Doctor') }}</option>
                                        <option value="Master" {{ old('pendidikan_terakhir_ibu', $data['pendidikan_terakhir_ibu']) == 'Master' ? 'selected' : '' }}>{{ __('Master') }}</option>
                                        <option value="Bachelor" {{ old('pendidikan_terakhir_ibu', $data['pendidikan_terakhir_ibu']) == 'Bachelor' ? 'selected' : '' }}>{{ __('Bachelor') }}</option>
                                        <option value="Diploma" {{ old('pendidikan_terakhir_ibu', $data['pendidikan_terakhir_ibu']) == 'Diploma' ? 'selected' : '' }}>{{ __('Diploma') }}</option>
                                        <option value="Senior High Schoool" {{ old('pendidikan_terakhir_ibu', $data['pendidikan_terakhir_ibu']) == 'Senior High School' ? 'selected' : '' }}>{{ __('Senior High School') }}</option>
                                        <option value="Junior High School" {{ old('pendidikan_terakhir_ibu', $data['pendidikan_terakhir_ibu']) == 'Junior High Shool' ? 'selected' : '' }}>{{ __('Junior High School') }}</option>
                                        <option value="Elementary Schoool" {{ old('pendidikan_terakhir_ibu', $data['pendidikan_terakhir_ibu']) == 'Elementary School' ? 'selected' : '' }}>{{ __('Elementary School') }}</option>
                                        <option value="Other" {{ old('pendidikan_terakhir_ibu', $data['pendidikan_terakhir_ibu']) == 'Other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                    </select>

                                    @error('pendidikan_terakhir_ibu')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-3">
                                    <label for="jabatan_terakhir_ibu">{{ __('Last Position') }}</label>
                                    <input type="text" class="form-control @error('jabatan_terakhir_ibu') is-invalid @enderror" id="jabatan_terakhir_ibu" name="jabatan_terakhir_ibu" value="{{ old('jabatan_terakhir_ibu', $data['jabatan_terakhir_ibu']) }}">

                                    @error('jabatan_terakhir_ibu')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-3">
                                    <label for="perusahaan_ibu">{{ __('Company') }}</label>
                                    <input type="text" class="form-control @error('perusahaan_ibu') is-invalid @enderror" id="perusahaan_ibu" name="perusahaan_ibu" value="{{ old('perusahaan_ibu', $data['perusahaan_ibu']) }}">

                                    @error('perusahaan_ibu')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="keterangan_ibu">{{ __('Information') }}</label>
                                    <input type="text" class="form-control @error('keterangan_ibu') is-invalid @enderror" id="keterangan_ibu" name="keterangan_ibu" value="{{ old('keterangan_ibu', $data['keterangan_ibu']) }}">

                                    @error('keterangan_ibu')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8" >
                                    <div class="kt-heading kt-heading--md" >{{ __('Sibling') }} 1</div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-3">
                                    <label for="nama_saudara">{{ __('Name') }}</label>
                                    <input type="text" class="form-control @error('nama_saudara') is-invalid @enderror" id="nama_saudara" name="saudara[0][nama_saudara]" value="{{ old('nama_saudara', $data['saudara'][0]['nama_saudara']) }}">

                                    @error('nama_saudara')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="jenis_kelamin_saudara">{{ __('Gender') }}</label>
                                    <select class="form-control @error('jenis_kelamin_saudara') is-invalid @enderror" id="jenis_kelamin_saudara" name="saudara[0][jenis_kelamin_saudara]">
                                        <option value="Male"  {{ (old('jenis_kelamin_saudara', $data['saudara'][0]['jenis_kelamin_saudara']) == 'Male' ? 'selected' : '') }}>{{ __('Male') }}</option>
                                        <option value="Female" {{ (old('jenis_kelamin_saudara', $data['saudara'][0]['jenis_kelamin_saudara']) == 'Female' ? 'selected' : '') }}>{{ __('Female') }}</option>
                                    </select>

                                    @error('jenis_kelamin_saudara')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-1">
                                    <label for="usia_saudara">{{ __('Age') }}</label>
                                    <input type="number" class="form-control @error('usia_saudara') is-invalid @enderror" id="usia_saudara" name="saudara[0][usia_saudara]" value="{{ old('usia_saudara', $data['saudara'][0]['usia_saudara']) }}">

                                    @error('usia_saudara')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="pendidikan_terakhir_saudara">{{ __('Last Education') }}</label>
                                    <select class="form-control @error('pendidikan_terakhir_saudara') is-invalid @enderror" id="pendidikan_terakhir_saudara" name="saudara[0][pendidikan_terakhir_saudara]">
                                        <option value="Doctor" {{ $data['saudara'][0]['pendidikan_terakhir_saudara'] == 'Doctor' ? 'selected' : '' }}>{{ __('Doctor') }}</option>
                                        <option value="Master" {{ $data['saudara'][0]['pendidikan_terakhir_saudara'] == 'Master' ? 'selected' : '' }}>{{ __('Master') }}</option>
                                        <option value="Bachelor" {{ $data['saudara'][0]['pendidikan_terakhir_saudara'] == 'Bachelor' ? 'selected' : '' }}>{{ __('Bachelor') }}</option>
                                        <option value="Diploma" {{ $data['saudara'][0]['pendidikan_terakhir_saudara'] == 'Diploma' ? 'selected' : '' }}>{{ __('Diploma') }}</option>
                                        <option value="Senior High Schoool" {{ $data['saudara'][0]['pendidikan_terakhir_saudara'] == 'Senior High School' ? 'selected' : '' }}>{{ __('Senior High School') }}</option>
                                        <option value="Junior High School" {{ $data['saudara'][0]['pendidikan_terakhir_saudara'] == 'Junior High Shool' ? 'selected' : '' }}>{{ __('Junior High School') }}</option>
                                        <option value="Elementary Schoool" {{ $data['saudara'][0]['pendidikan_terakhir_saudara'] == 'Elementary School' ? 'selected' : '' }}>{{ __('Elementary School') }}</option>
                                        <option value="Other" {{ $data['saudara'][0]['pendidikan_terakhir_saudara'] == 'Other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                    </select>

                                    @error('pendidikan_terakhir_saudara')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-3">
                                    <label for="jabatan_terakhir_saudara">{{ __('Last Position') }}</label>
                                    <input type="text" class="form-control @error('jabatan_terakhir_saudara') is-invalid @enderror" id="jabatan_terakhir_saudara" name="saudara[0][jabatan_terakhir_saudara]" value="{{ old('jabatan_terakhir_saudara', $data['saudara'][0]['jabatan_terakhir_saudara']) }}">

                                    @error('jabatan_terakhir_saudara')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-3">
                                    <label for="perusahaan_saudara">{{ __('Company') }}</label>
                                    <input type="text" class="form-control @error('perusahaan_saudara') is-invalid @enderror" id="perusahaan_saudara" name="saudara[0][perusahaan_saudara]" value="{{ old('perusahaan_saudara', $data['saudara'][0]['perusahaan_saudara']) }}">

                                    @error('perusahaan_saudara')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="keterangan_saudara">{{ __('Information') }}</label>
                                    <input type="text" class="form-control @error('keterangan_saudara') is-invalid @enderror" id="keterangan_saudara" name="saudara[0][keterangan_saudara]" value="{{ old('keterangan_saudara', $data['saudara'][0]['keterangan_saudara']) }}">

                                    @error('keterangan_saudara')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            @if ($data && count($data['saudara']) > 1)
                                @for ($i = 1; $i < count($data['saudara']); $i++)
                                    <div class="siblings">
                                        <div class="row justify-content-center">
                                            <div class="form-group col-lg-8" >
                                                <div class="kt-heading kt-heading--md">
                                                <span class="sibling-title">{{ __('Sibling') }} {{ $i + 1 }}</span>
                                                    <button type="button" class="btn btn-danger btn-sm btn-icon btn-remove-siblings btn-tooltip" title="{{ __('Delete') }}">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row justify-content-center">
                                            <div class="form-group col-lg-3">
                                                <label>{{ __('Name') }}</label>
                                                <input type="text" class="form-control" name="saudara[{{ $i }}][nama_saudara]" value="{{ $data['saudara'][$i]['nama_saudara'] }}">
                                            </div>

                                            <div class="form-group col-lg-2">
                                                <label>{{ __('Gender') }}</label>
                                                <select class="form-control" name="saudara[{{ $i }}][jenis_kelamin_saudara]">
                                                    <option value="Male" {{ $data['saudara'][$i]['jenis_kelamin_saudara'] == 'Male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                                    <option value="Female" {{ $data['saudara'][$i]['jenis_kelamin_saudara'] == 'Female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-lg-1">
                                                <label>{{ __('Age') }}</label>
                                                <input type="number" class="form-control" name="saudara[{{ $i }}][usia_saudara]" value="{{ $data['saudara'][$i]['usia_saudara'] }}">
                                            </div>

                                            <div class="form-group col-lg-2">
                                                <label>{{ __('Last Education') }}</label>
                                                <select class="form-control" name="saudara[{{ $i }}][pendidikan_terakhir_saudara]">
                                                    <option value="Doctor" {{ $data['saudara'][$i]['pendidikan_terakhir_saudara'] == 'Doctor' ? 'selected' : '' }}>{{ __('Doctor') }}</option>
                                                    <option value="Master" {{ $data['saudara'][$i]['pendidikan_terakhir_saudara'] == 'Master' ? 'selected' : '' }}>{{ __('Master') }}</option>
                                                    <option value="Bachelor" {{ $data['saudara'][$i]['pendidikan_terakhir_saudara'] == 'Bachelor' ? 'selected' : '' }}>{{ __('Bachelor') }}</option>
                                                    <option value="Diploma" {{ $data['saudara'][$i]['pendidikan_terakhir_saudara'] == 'Diploma' ? 'selected' : '' }}>{{ __('Diploma') }}</option>
                                                    <option value="Senior High Schoool" {{ $data['saudara'][$i]['pendidikan_terakhir_saudara'] == 'Senior High School' ? 'selected' : '' }}>{{ __('Senior High School') }}</option>
                                                    <option value="Junior High School" {{ $data['saudara'][$i]['pendidikan_terakhir_saudara'] == 'Junior High Shool' ? 'selected' : '' }}>{{ __('Junior High School') }}</option>
                                                    <option value="Elementary Schoool" {{ $data['saudara'][$i]['pendidikan_terakhir_saudara'] == 'Elementary School' ? 'selected' : '' }}>{{ __('Elementary School') }}</option>
                                                    <option value="Other" {{ $data['saudara'][$i]['pendidikan_terakhir_saudara'] == 'Other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row justify-content-center">
                                            <div class="form-group col-lg-3">
                                                <label>{{ __('Last Position') }}</label>
                                                <input type="text" class="form-control" name="saudara[{{ $i }}][jabatan_terakhir_saudara]" value="{{ $data['saudara'][$i]['jabatan_terakhir_saudara'] }}">
                                            </div>

                                            <div class="form-group col-lg-3">
                                                <label>{{ __('Company') }}</label>
                                                <input type="text" class="form-control" name="saudara[{{ $i }}][perusahaan_saudara]" value="{{ $data['saudara'][$i]['perusahaan_saudara'] }}">
                                            </div>

                                            <div class="form-group col-lg-2">
                                                <label>{{ __('Information') }}</label>
                                                <input type="text" class="form-control" name="saudara[{{ $i }}][keterangan_saudara]" value="{{ $data['saudara'][$i]['keterangan_saudara'] }}">
                                            </div>
                                        </div>
                                    </div> 
                                @endfor
                            @endif
                                             
                            <div class="siblings d-none" id="siblings">
                                <div class="row justify-content-center">
                                    <div class="form-group col-lg-8" >
                                        <div class="kt-heading kt-heading--md">
                                            <span class="sibling-title">{{ __('Sibling') }}</span>
                                            <button type="button" class="btn btn-danger btn-sm btn-icon btn-remove-siblings btn-tooltip" title="{{ __('Delete') }}">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-center">
                                    <div class="form-group col-lg-3">
                                        <label>{{ __('Name') }}</label>
                                        <input type="text" class="form-control input-name">
                                    </div>

                                    <div class="form-group col-lg-2">
                                        <label for="jenis_kelamin_saudara">{{ __('Gender') }}</label>
                                        <select class="form-control input-gender" name="saudara[0][jenis_kelamin_saudara]">
                                            <option value="Male" {{ old('jenis_kelamin_saudara', $data['saudara'][0]['jenis_kelamin_saudara']) == 'Male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                            <option value="Female" {{ old('jenis_kelamin_saudara', $data['saudara'][0]['jenis_kelamin_saudara']) == 'Female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-1">
                                        <label for="usia_saudara">{{ __('Age') }}</label>
                                        <input type="number" class="form-control input-age">
                                    </div>

                                    <div class="form-group col-lg-2">
                                        <label for="pendidikan_terakhir_saudara">{{ __('Last Education') }}</label>
                                        <select class="form-control input-last-education" name="saudara[0][pendidikan_terakhir_saudara]">
                                            <option value="Doctor" {{ old('pendidikan_terakhir_saudara', $data['saudara'][0]['pendidikan_terakhir_saudara']) == 'Doctor' ? 'selected' : '' }}>{{ __('Doctor') }}</option>
                                            <option value="Master" {{ old('pendidikan_terakhir_saudara', $data['saudara'][0]['pendidikan_terakhir_saudara']) == 'Master' ? 'selected' : '' }}>{{ __('Master') }}</option>
                                            <option value="Bachelor" {{ old('pendidikan_terakhir_saudara', $data['saudara'][0]['pendidikan_terakhir_saudara']) == 'Bachelor' ? 'selected' : '' }}>{{ __('Bachelor') }}</option>
                                            <option value="Diploma" {{ old('pendidikan_terakhir_saudara', $data['saudara'][0]['pendidikan_terakhir_saudara']) == 'Diploma' ? 'selected' : '' }}>{{ __('Diploma') }}</option>
                                            <option value="Senior High Schoool" {{ old('pendidikan_terakhir_saudara', $data['saudara'][0]['pendidikan_terakhir_saudara']) == 'Senior High School' ? 'selected' : '' }}>{{ __('Senior High School') }}</option>
                                            <option value="Junior High School" {{ old('pendidikan_terakhir_saudara', $data['saudara'][0]['pendidikan_terakhir_saudara']) == 'Junior High Shool' ? 'selected' : '' }}>{{ __('Junior High School') }}</option>
                                            <option value="Elementary Schoool" {{ old('pendidikan_terakhir_saudara', $data['saudara'][0]['pendidikan_terakhir_saudara']) == 'Elementary School' ? 'selected' : '' }}>{{ __('Elementary School') }}</option>
                                            <option value="Other" {{ old('pendidikan_terakhir_saudara', $data['saudara'][0]['pendidikan_terakhir_saudara']) == 'Other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                        </select>
                                    </div>
                                    
                                </div>

                                <div class="row justify-content-center">
                                    <div class="form-group col-lg-3">
                                        <label for="jabatan_terakhir_saudara">{{ __('Last Position') }}</label>
                                        <input type="text" class="form-control input-last-position">
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="perusahaan_saudara">{{ __('Company') }}</label>
                                        <input type="text" class="form-control input-company">
                                    </div>

                                    <div class="form-group col-lg-2">
                                        <label for="keterangan_saudara">{{ __('Information') }}</label>
                                        <input type="text" class="form-control input-information">
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <button type="button" class="btn btn-primary" id="btn-add-siblings"><i class="fa fa-plus"></i>{{ __('Add') }} {{ __('Sibling') }}</button>
                                </div>
                            </div>

                            @if($dataStepOne['status_pernikahan'] == 'Married')
                                @if($dataStepOne['jenis_kelamin'] == 'Female')                         
                                    <div class="row justify-content-center">
                                        <div class="form-group col-lg-8" > 
                                            <div class="kt-heading kt-heading--md" >{{ __('Husband') }}</div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-center">
                                        <div class="form-group col-lg-3">
                                            <label for="nama_suami">{{ __('Name') }}</label>
                                            <input type="text" class="form-control @error('nama_suami') is-invalid @enderror" id="nama_suami" name="nama_suami" value="{{ old('nama_suami', $data['nama_suami']) }}">

                                            @error('nama_suami')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-2">
                                            <label for="usia_suami">{{ __('Age') }}</label>
                                            <input type="number" class="form-control @error('usia_suami') is-invalid @enderror" id="usia_suami" name="usia_suami" value="{{ old('usia_suami', $data['usia_suami']) }}">

                                            @error('usia_suami')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="pendidikan_terakhir_suami">{{ __('Last Education') }}</label>
                                            <select class="form-control @error('pendidikan_terakhir_suami') is-invalid @enderror" id="pendidikan_terakhir_suami" name="pendidikan_terakhir_suami">
                                                <option value="Doctor" {{ old('pendidikan_terakhir_suami', $data['pendidikan_terakhir_suami']) == 'Doctor' ? 'selected' : '' }}>{{ __('Doctor') }}</option>
                                                <option value="Master" {{ old('pendidikan_terakhir_suami', $data['pendidikan_terakhir_suami']) == 'Master' ? 'selected' : '' }}>{{ __('Master') }}</option>
                                                <option value="Bachelor" {{ old('pendidikan_terakhir_suami', $data['pendidikan_terakhir_suami']) == 'Bachelor' ? 'selected' : '' }}>{{ __('Bachelor') }}</option>
                                                <option value="Diploma" {{ old('pendidikan_terakhir_suami', $data['pendidikan_terakhir_suami']) == 'Diploma' ? 'selected' : '' }}>{{ __('Diploma') }}</option>
                                                <option value="Senior High Schoool" {{ old('pendidikan_terakhir_suami', $data['pendidikan_terakhir_suami']) == 'Senior High School' ? 'selected' : '' }}>{{ __('Senior High School') }}</option>
                                                <option value="Junior High School" {{ old('pendidikan_terakhir_suami', $data['pendidikan_terakhir_suami']) == 'Junior High Shool' ? 'selected' : '' }}>{{ __('Junior High School') }}</option>
                                                <option value="Elementary Schoool" {{ old('pendidikan_terakhir_suami', $data['pendidikan_terakhir_suami']) == 'Elementary School' ? 'selected' : '' }}>{{ __('Elementary School') }}</option>
                                                <option value="Other" {{ old('pendidikan_terakhir_suami', $data['pendidikan_terakhir_suami']) == 'Other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                            </select>

                                            @error('pendidikan_terakhir_suami')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row justify-content-center">
                                        <div class="form-group col-lg-3">
                                            <label for="jabatan_terakhir_suami">{{ __('Last Position') }}</label>
                                            <input type="text" class="form-control @error('jabatan_terakhir_suami') is-invalid @enderror" id="jabatan_terakhir_suami" name="jabatan_terakhir_suami" value="{{ old('jabatan_terakhir_suami', $data['jabatan_terakhir_suami']) }}">

                                            @error('jabatan_terakhir_suami')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="perusahaan_suami">{{ __('Company') }}</label>
                                            <input type="text" class="form-control @error('perusahaan_suami') is-invalid @enderror" id="perusahaan_suami" name="perusahaan_suami" value="{{ old('perusahaan_suami', $data['perusahaan_suami']) }}">

                                            @error('perusahaan_suami')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-2">
                                            <label for="keterangan_suami">{{ __('Information') }}</label>
                                            <input type="text" class="form-control @error('keterangan_suami') is-invalid @enderror" id="keterangan_suami" name="keterangan_suami" value="{{ old('keterangan_suami', $data['keterangan_suami']) }}">

                                            @error('keterangan_suami')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                @else
                                                               
                                    <div class="row justify-content-center">
                                        <div class="form-group col-lg-8" >
                                            <div class="kt-heading kt-heading--md" >{{ __('Wife') }}</div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-center">
                                        <div class="form-group col-lg-3">
                                            <label for="nama_istri">{{ __('Name') }}</label>
                                            <input type="text" class="form-control @error('nama_istri') is-invalid @enderror" id="nama_istri" name="nama_istri" value="{{ old('nama_istri', $data['nama_istri']) }}">

                                            @error('nama_istri')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-2">
                                            <label for="usia_istri">{{ __('Age') }}</label>
                                            <input type="number" class="form-control @error('usia_istri') is-invalid @enderror" id="usia_istri" name="usia_istri" value="{{ old('usia_istri', $data['usia_istri']) }}">

                                            @error('usia_istri')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="pendidikan_terakhir_istri">{{ __('Last Education') }}</label>
                                            <select class="form-control @error('pendidikan_terakhir_istri') is-invalid @enderror" id="pendidikan_terakhir_istri" name="pendidikan_terakhir_istri">
                                                <option value="Doctor" {{ old('pendidikan_terakhir_istri', $data['pendidikan_terakhir_istri']) == 'Doctor' ? 'selected' : '' }}>{{ __('Doctor') }}</option>
                                                <option value="Master" {{ old('pendidikan_terakhir_istri', $data['pendidikan_terakhir_istri']) == 'Master' ? 'selected' : '' }}>{{ __('Master') }}</option>
                                                <option value="Bachelor" {{ old('pendidikan_terakhir_istri', $data['pendidikan_terakhir_istri']) == 'Bachelor' ? 'selected' : '' }}>{{ __('Bachelor') }}</option>
                                                <option value="Diploma" {{ old('pendidikan_terakhir_istri', $data['pendidikan_terakhir_istri']) == 'Diploma' ? 'selected' : '' }}>{{ __('Diploma') }}</option>
                                                <option value="Senior High Schoool" {{ old('pendidikan_terakhir_istri', $data['pendidikan_terakhir_istri']) == 'Senior High School' ? 'selected' : '' }}>{{ __('Senior High School') }}</option>
                                                <option value="Junior High School" {{ old('pendidikan_terakhir_istri', $data['pendidikan_terakhir_istri']) == 'Junior High Shool' ? 'selected' : '' }}>{{ __('Junior High School') }}</option>
                                                <option value="Elementary Schoool" {{ old('pendidikan_terakhir_istri', $data['pendidikan_terakhir_istri']) == 'Elementary School' ? 'selected' : '' }}>{{ __('Elementary School') }}</option>
                                                <option value="Other" {{ old('pendidikan_terakhir_istri', $data['pendidikan_terakhir_istri']) == 'Other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                            </select>

                                            @error('pendidikan_terakhir_istri')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row justify-content-center">
                                        <div class="form-group col-lg-3">
                                            <label for="jabatan_terakhir_istri">{{ __('Last Position') }}</label>
                                            <input type="text" class="form-control @error('jabatan_terakhir_istri') is-invalid @enderror" id="jabatan_terakhir_istri" name="jabatan_terakhir_istri" value="{{ old('jabatan_terakhir_istri', $data['jabatan_terakhir_istri']) }}">

                                            @error('jabatan_terakhir_istri')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-3">
                                            <label for="perusahaan_istri">{{ __('Company') }}</label>
                                            <input type="text" class="form-control @error('perusahaan_istri') is-invalid @enderror" id="perusahaan_istri" name="perusahaan_istri" value="{{ old('perusahaan_istri', $data['perusahaan_istri']) }}">

                                            @error('perusahaan_istri')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-2">
                                            <label for="keterangan_istri">{{ __('Information') }}</label>
                                            <input type="text" class="form-control @error('keterangan_istri') is-invalid @enderror" id="keterangan_istri" name="keterangan_istri" value="{{ old('keterangan_istri', $data['keterangan_istri']) }}">

                                            @error('keterangan_istri')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                            @endif

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8" >
                                    <div class="kt-heading kt-heading--md" >{{ __('Child') }} 1</div>
                                </div>
                            </div>
                        
                            <div class="row justify-content-center">
                                <div class="form-group col-lg-3">
                                    <label for="nama_anak">{{ __('Name') }}</label>
                                    <input type="text" class="form-control @error('nama_anak') is-invalid @enderror" id="nama_anak" name="anak[0][nama_anak]" value="{{ old('nama_anak', $data['anak'][0]['nama_anak']) }}">

                                    @error('nama_anak')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="jenis_kelamin_anak">{{ __('Gender') }}</label>
                                    <select class="form-control @error('jenis_kelamin_anak') is-invalid @enderror" id="jenis_kelamin_anak" name="anak[0][jenis_kelamin_anak]">
                                        <option value="Male" {{ old('jenis_kelamin_anak', $data['anak'][0]['jenis_kelamin_anak']) == 'Male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                        <option value="Female" {{ old('jenis_kelamin_anak', $data['anak'][0]['jenis_kelamin_anak']) == 'Female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                    </select>

                                    @error('jenis_kelamin_anak')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-1">
                                    <label for="usia_anak">{{ __('Age') }}</label>
                                    <input type="number" class="form-control @error('usia_anak') is-invalid @enderror" id="usia_anak" name="anak[0][usia_anak]" value="{{ old('usia_saudara', $data['anak'][0]['usia_anak']) }}">

                                    @error('usia_anak')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="pendidikan_terakhir_anak">{{ __('Last Education') }}</label>
                                    <select class="form-control @error('pendidikan_terakhir_anak') is-invalid @enderror" id="pendidikan_terakhir_anak" name="anak[0][pendidikan_terakhir_anak]">
                                        <option value="Doctor" {{ old('pendidikan_terakhir_anak', $data['anak'][0]['pendidikan_terakhir_anak']) == 'Doctor' ? 'selected' : '' }}>{{ __('Doctor') }}</option>
                                        <option value="Master" {{ old('pendidikan_terakhir_anak', $data['anak'][0]['pendidikan_terakhir_anak']) == 'Master' ? 'selected' : '' }}>{{ __('Master') }}</option>
                                        <option value="Bachelor" {{ old('pendidikan_terakhir_anak', $data['anak'][0]['pendidikan_terakhir_anak']) == 'Bachelor' ? 'selected' : '' }}>{{ __('Bachelor') }}</option>
                                        <option value="Diploma" {{ old('pendidikan_terakhir_anak', $data['anak'][0]['pendidikan_terakhir_anak']) == 'Diploma' ? 'selected' : '' }}>{{ __('Diploma') }}</option>
                                        <option value="Senior High Schoool" {{ old('pendidikan_terakhir_anak', $data['anak'][0]['pendidikan_terakhir_anak']) == 'Senior High School' ? 'selected' : '' }}>{{ __('Senior High School') }}</option>
                                        <option value="Junior High School" {{ old('pendidikan_terakhir_anak', $data['anak'][0]['pendidikan_terakhir_anak']) == 'Junior High Shool' ? 'selected' : '' }}>{{ __('Junior High School') }}</option>
                                        <option value="Elementary Schoool" {{ old('pendidikan_terakhir_anak', $data['anak'][0]['pendidikan_terakhir_anak']) == 'Elementary School' ? 'selected' : '' }}>{{ __('Elementary School') }}</option>
                                        <option value="Other" {{ old('pendidikan_terakhir_anak', $data['anak'][0]['pendidikan_terakhir_anak']) == 'Other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                    </select>

                                    @error('pendidikan_terakhir_anak')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row justify-content-center">
                                <div class="form-group col-lg-3">
                                    <label for="jabatan_terakhir_anak">{{ __('Last Position') }}</label>
                                    <input type="text" class="form-control @error('jabatan_terakhir_anak') is-invalid @enderror" id="jabatan_terakhir_anak" name="anak[0][jabatan_terakhir_anak]" value="{{ old('jabatan_terakhir_anak', $data['anak'][0]['jabatan_terakhir_anak']) }}">

                                    @error('jabatan_terakhir_anak')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-3">
                                    <label for="perusahaan_anak">{{ __('Company') }}</label>
                                    <input type="text" class="form-control @error('perusahaan_anak') is-invalid @enderror" id="perusahaan_anak" name="anak[0][perusahaan_anak]" value="{{ old('perusahaan_anak', $data['anak'][0]['perusahaan_anak']) }}">

                                    @error('perusahaan_anak')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="keterangan_anak">{{ __('Information') }}</label>
                                    <input type="text" class="form-control @error('keterangan_anak') is-invalid @enderror" id="keterangan_anak" name="anak[0][keterangan_anak]" value="{{ old('keterangan_anak', $data['anak'][0]['keterangan_anak']) }}">

                                    @error('keterangan_anak')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            @if ($data && count($data['anak']) > 1)
                                @for ($i = 1; $i < count($data['anak']); $i++)
                                    <div class="childs">
                                        <div class="row justify-content-center">
                                            <div class="form-group col-lg-8" >
                                                <div class="kt-heading kt-heading--md">
                                                <span class="child-title">{{ __('Child') }} {{ $i + 1 }}</span>
                                                    <button type="button" class="btn btn-danger btn-sm btn-icon btn-remove-childs btn-tooltip" title="{{ __('Delete') }}">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row justify-content-center">
                                            <div class="form-group col-lg-3">
                                                <label>{{ __('Name') }}</label>
                                                <input type="text" class="form-control" name="anak[{{ $i }}][nama_anak]" value="{{ $data['anak'][$i]['nama_anak'] }}">
                                            </div>

                                            <div class="form-group col-lg-2">
                                                <label>{{ __('Gender') }}</label>
                                                <select class="form-control" name="anak[{{ $i }}][jenis_kelamin_anak]">
                                                    <option value="Male" {{ $data['anak'][$i]['jenis_kelamin_anak'] == 'Male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                                    <option value="Female" {{ $data['anak'][$i]['jenis_kelamin_anak'] == 'Female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-lg-1">
                                                <label>{{ __('Age') }}</label>
                                                <input type="number" class="form-control" name="anak[{{ $i }}][usia_anak]" value="{{ $data['anak'][$i]['usia_anak'] }}">
                                            </div>

                                            <div class="form-group col-lg-2">
                                                <label>{{ __('Last Education') }}</label>
                                                <select class="form-control" name="anak[{{ $i }}][pendidikan_terakhir_anak]">
                                                    <option value="Doctor" {{ $data['anak'][$i]['pendidikan_terakhir_anak'] == 'Doctor' ? 'selected' : '' }}>{{ __('Doctor') }}</option>
                                                    <option value="Master" {{ $data['anak'][$i]['pendidikan_terakhir_anak'] == 'Master' ? 'selected' : '' }}>{{ __('Master') }}</option>
                                                    <option value="Bachelor" {{ $data['anak'][$i]['pendidikan_terakhir_anak'] == 'Bachelor' ? 'selected' : '' }}>{{ __('Bachelor') }}</option>
                                                    <option value="Diploma" {{ $data['anak'][$i]['pendidikan_terakhir_anak'] == 'Diploma' ? 'selected' : '' }}>{{ __('Diploma') }}</option>
                                                    <option value="Senior High Schoool" {{ $data['anak'][$i]['pendidikan_terakhir_anak'] == 'Senior High School' ? 'selected' : '' }}>{{ __('Senior High School') }}</option>
                                                    <option value="Junior High School" {{ $data['anak'][$i]['pendidikan_terakhir_anak'] == 'Junior High Shool' ? 'selected' : '' }}>{{ __('Junior High School') }}</option>
                                                    <option value="Elementary Schoool" {{ $data['anak'][$i]['pendidikan_terakhir_anak'] == 'Elementary School' ? 'selected' : '' }}>{{ __('Elementary School') }}</option>
                                                    <option value="Other" {{ $data['anak'][$i]['pendidikan_terakhir_anak'] == 'Other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row justify-content-center">
                                            <div class="form-group col-lg-3">
                                                <label>{{ __('Last Position') }}</label>
                                                <input type="text" class="form-control" name="anak[{{ $i }}][jabatan_terakhir_anak]" value="{{ $data['anak'][$i]['jabatan_terakhir_anak'] }}">
                                            </div>

                                            <div class="form-group col-lg-3">
                                                <label>{{ __('Company') }}</label>
                                                <input type="text" class="form-control" name="anak[{{ $i }}][perusahaan_anak]" value="{{ $data['anak'][$i]['perusahaan_anak'] }}">
                                            </div>

                                            <div class="form-group col-lg-2">
                                                <label>{{ __('Information') }}</label>
                                                <input type="text" class="form-control" name="anak[{{ $i }}][keterangan_anak]" value="{{ $data['anak'][$i]['keterangan_anak'] }}">
                                            </div>
                                        </div>
                                    </div> 
                                @endfor
                            @endif
                                             
                            <div class="childs d-none" id="childs">
                                <div class="row justify-content-center">
                                    <div class="form-group col-lg-8" >
                                        <div class="kt-heading kt-heading--md">
                                            <span class="child-title">{{ __('Child') }}</span>
                                            <button type="button" class="btn btn-danger btn-sm btn-icon btn-remove-childs btn-tooltip" title="{{ __('Delete') }}">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-center">
                                    <div class="form-group col-lg-3">
                                        <label>{{ __('Name') }}</label>
                                        <input type="text" class="form-control input-name">
                                    </div>

                                    <div class="form-group col-lg-2">
                                        <label for="jenis_kelamin_anak">{{ __('Gender') }}</label>
                                        <select class="form-control input-gender" name="anak[0][jenis_kelamin_anak]">
                                            <option value="Male" {{ old('jenis_kelamin_anak', $data['anak'][0]['jenis_kelamin_anak']) == 'Male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                            <option value="Female" {{ old('jenis_kelamin_anak', $data['anak'][0]['jenis_kelamin_anak']) == 'Female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-1">
                                        <label for="usia_anak">{{ __('Age') }}</label>
                                        <input type="number" class="form-control input-age">
                                    </div>

                                    
                                    <div class="form-group col-lg-2">
                                        <label for="pendidikan_terakhir_anak">{{ __('Last Education') }}</label>
                                        <select class="form-control input-last-education" name="anak[0][pendidikan_terakhir_anak]">
                                            <option value="Doctor" {{ old('pendidikan_terakhir_anak', $data['anak'][0]['pendidikan_terakhir_anak']) == 'Doctor' ? 'selected' : '' }}>{{ __('Doctor') }}</option>
                                            <option value="Master" {{ old('pendidikan_terakhir_anak', $data['anak'][0]['pendidikan_terakhir_anak']) == 'Master' ? 'selected' : '' }}>{{ __('Master') }}</option>
                                            <option value="Bachelor" {{ old('pendidikan_terakhir_anak', $data['anak'][0]['pendidikan_terakhir_anak']) == 'Bachelor' ? 'selected' : '' }}>{{ __('Bachelor') }}</option>
                                            <option value="Diploma" {{ old('pendidikan_terakhir_anak', $data['anak'][0]['pendidikan_terakhir_anak']) == 'Diploma' ? 'selected' : '' }}>{{ __('Diploma') }}</option>
                                            <option value="Senior High Schoool" {{ old('pendidikan_terakhir_anak', $data['anak'][0]['pendidikan_terakhir_anak']) == 'Senior High School' ? 'selected' : '' }}>{{ __('Senior High School') }}</option>
                                            <option value="Junior High School" {{ old('pendidikan_terakhir_anak', $data['anak'][0]['pendidikan_terakhir_anak']) == 'Junior High Shool' ? 'selected' : '' }}>{{ __('Junior High School') }}</option>
                                            <option value="Elementary Schoool" {{ old('pendidikan_terakhir_anak', $data['anak'][0]['pendidikan_terakhir_anak']) == 'Elementary School' ? 'selected' : '' }}>{{ __('Elementary School') }}</option>
                                            <option value="Other" {{ old('pendidikan_terakhir_anak', $data['anak'][0]['pendidikan_terakhir_anak']) == 'Other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                        </select>
                                    </div>
                                    
                                </div>

                                <div class="row justify-content-center">
                                    <div class="form-group col-lg-3">
                                        <label for="jabatan_terakhir_anak">{{ __('Last Position') }}</label>
                                        <input type="text" class="form-control input-last-position">
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="perusahaan_anak">{{ __('Company') }}</label>
                                        <input type="text" class="form-control input-company">
                                    </div>

                                    <div class="form-group col-lg-2">
                                        <label for="keterangan_anak">{{ __('Information') }}</label>
                                        <input type="text" class="form-control input-information">
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <button type="button" class="btn btn-primary" id="btn-add-childs"><i class="fa fa-plus"></i>{{ __('Add') }} {{ __('Child') }}</button>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group col-lg-8">
                            <div class="kt-form__actions">
                                <a href="{{ route('recruitment.register.step-1', $id) }}" class="btn btn-outline-brand btn-md btn-tall btn-wide btn-bold btn-upper">
                                    {{ __('Back') }}
                                </a>
        
                                <button type="submit" class="btn btn-brand btn-md btn-tall btn-wide btn-bold btn-upper" data-ktwizard-type="action-next">
                                    {{ __('Next Step') }}
                                </button>
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
    <script>
        var siblingQty = parseInt("{{ $data ? count($data['saudara']) : 1 }}");
        var childQty = parseInt("{{ $data ? count($data['anak']) : 1 }}");
        $('#btn-add-siblings').click(function() {
            var template = $('#siblings');
            var clone = template.clone().removeAttr('id').removeClass('d-none');
            $('.input-name', clone).attr('name', 'saudara['+siblingQty+'][nama_saudara]');
            $('.input-gender', clone).attr('name', 'saudara['+siblingQty+'][jenis_kelamin_saudara]');
            $('.input-age', clone).attr('name', 'saudara['+siblingQty+'][usia_saudara]');
            $('.input-last-education', clone).attr('name', 'saudara['+siblingQty+'][pendidikan_terakhir_saudara]');
            $('.input-last-position', clone).attr('name', 'saudara['+siblingQty+'][jabatan_terakhir_saudara]');
            $('.input-company', clone).attr('name', 'saudara['+siblingQty+'][perusahaan_saudara]');
            $('.input-information', clone).attr('name', 'saudara['+siblingQty+'][keterangan_saudara]');
            $('.btn-remove-siblings', clone).click(function() {
                $(this).closest('div.siblings').remove();

                siblingQty--;
            });
            template.before(clone);
            
            siblingQty++;
            $('.sibling-title', clone).attr('id', 'sibling-' + siblingQty);
            $('#sibling-' + siblingQty).text("{{ __('Sibling') }}" + ' ' + siblingQty);
        });

        $('.btn-remove-siblings').click(function() {
            $(this).closest('div.siblings').remove();

            siblingQty--;
        });

        $('#btn-add-childs').click(function() {
            var template = $('#childs');
            var clone = template.clone().removeAttr('id').removeClass('d-none');
            $('.input-name', clone).attr('name', 'anak['+childQty+'][nama_anak]');
            $('.input-gender', clone).attr('name', 'anak['+childQty+'][jenis_kelamin_anak]');
            $('.input-age', clone).attr('name', 'anak['+childQty+'][usia_anak]');
            $('.input-last-education', clone).attr('name', 'anak['+childQty+'][pendidikan_terakhir_anak]');
            $('.input-last-position', clone).attr('name', 'anak['+childQty+'][jabatan_terakhir_anak]');
            $('.input-company', clone).attr('name', 'anak['+childQty+'][perusahaan_anak]');
            $('.input-information', clone).attr('name', 'anak['+childQty+'][keterangan_anak]');
            $('.btn-remove-childs', clone).click(function() {
                $(this).closest('div.childs').remove();

                childQty--;
            });
            template.before(clone);

            childQty++;
            $('.child-title', clone).attr('id', 'child-' + childQty);
            $('#child-' + childQty).text("{{ __('Child') }}" + ' ' + childQty);
        });
    </script>
@endsection