@extends('employee.register.layout')

@section('title')
    {{ __('Applicant Form') }} | {{ config('app.name') }}
@endsection

@section('style')
    <link href="{{ asset(mix('css/form/wizard.css')) }}" rel="stylesheet">
    <link href="{{ asset(mix('css/datatable.css')) }}" rel="stylesheet">
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
                            <div class="kt-wizard-v1__nav-item-title">{{ __('Educational Background (Formal / Informal)') }}</div>
                            <div class="kt-wizard-v1__nav-item-desc">{{ __('This form must be filled in completely. Incomplete filling will affect the processing of your application.')}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">
                <form class="kt-form" id="kt_form_1" action="{{ route('recruitment.register.step-3.validate', $id) }}" method="POST">
                    @csrf

                    <div class="kt-wizard-v1__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                        <div class="kt-separator kt-separator--height-xs"></div>
                        <div class="kt-form__section kt-form__section--first">
                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    @include('layouts.inc.alert')
                                    <h4 class="kt-section__title">{{ __('Elementary School') }}</h4>
                                </div>
                            </div>
                            
                            <div class="row justify-content-center">
                                <div class="form-group col-lg-4">
                                    <label for="nama_sd">{{ __('School Name') }}</label>
                                    <input id="nama_sd" type="text" class="form-control @error('nama_sd') is-invalid @enderror" name="nama_sd" value="{{ old('nama_sd', $data['nama_sd']) }}">

                                    @error('nama_sd')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="kota_sd">{{ __('City') }} / {{ __('Regency') }}</label>
                                    <select id="kota_sd" name="kota_sd" class="form-control kt_selectpicker @error('kota_sd') is-invalid @enderror" data-live-search="true" title="{{ __('Choose') }} {{ __('City') }} / {{ __('Regency') }}">
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" {{ old('kota_sd', $data['kota_sd']) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('kota_sd')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-2">
                                    <label for="tahun_masuk_sd">{{ __('Year of Entry') }}</label>
                                    <input id="tahun_masuk_sd" type="text" class="form-control @error('tahun_masuk_sd') is-invalid @enderror" name="tahun_masuk_sd" value="{{ old('tahun_masuk_sd', $data['tahun_masuk_sd']) }}">

                                    @error('tahun_masuk_sd')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="tahun_keluar_sd">{{ __('Year Out') }}</label>
                                    <input id="tahun_keluar_sd" type="text" class="form-control @error('tahun_keluar_sd') is-invalid @enderror" name="tahun_keluar_sd" value="{{ old('tahun_keluar_sd', $data['tahun_keluar_sd']) }}">

                                    @error('tahun_keluar_sd')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="lulus_sd">{{ __('Graduate') }}</label><br>
                                    <span class="kt-switch kt-switch--sm kt-switch--icon kt-switch--primary kt-switch--outline">
                                        <label class="mb-0">
                                            <input type="checkbox" id="lulus_sd" name="lulus_sd" {{ old('lulus_sd', true) ? 'checked' : '' }}>
                                            <span class="m-0"></span>
                                        </label>
                                    </span>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <h4 class="kt-section__title">{{ __('Junior High School') }}</h4>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-4">
                                    <label for="nama_smp">{{ __('School Name') }}</label>
                                    <input id="nama_smp" type="text" class="form-control @error('nama_smp') is-invalid @enderror" name="nama_smp" value="{{ old('nama_smp', $data['nama_smp']) }}">

                                    @error('nama_smp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="kota_smp">{{ __('City') }} / {{ __('Regency') }}</label>
                                    <select id="kota_smp" name="kota_smp" class="form-control kt_selectpicker @error('kota_smp') is-invalid @enderror" data-live-search="true" title="{{ __('Choose') }} {{ __('City') }} / {{ __('Regency') }}">
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" {{ old('kota_smp', $data['kota_smp']) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('kota_smp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-2">
                                    <label for="tahun_masuk_smp">{{ __('Year of Entry') }}</label>
                                    <input id="tahun_masuk_smp" type="text" class="form-control @error('tahun_masuk_smp') is-invalid @enderror" name="tahun_masuk_smp" value="{{ old('tahun_masuk_smp', $data['tahun_masuk_smp']) }}">

                                    @error('tahun_masuk_smp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="tahun_keluar_smp">{{ __('Year Out') }}</label>
                                    <input id="tahun_keluar_smp" type="text" class="form-control @error('tahun_keluar_smp') is-invalid @enderror" name="tahun_keluar_smp" value="{{ old('tahun_keluar_smp', $data['tahun_keluar_smp']) }}">

                                    @error('tahun_keluar_smp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="lulus_smp">{{ __('Graduate') }}</label><br>
                                    <span class="kt-switch kt-switch--sm kt-switch--icon kt-switch--primary kt-switch--outline">
                                        <label class="mb-0">
                                            <input type="checkbox"  id="lulus_smp" name="lulus_smp" {{ old('lulus_smp', true) ? 'checked' : '' }}>
                                            <span class="m-0"></span>
                                        </label>
                                    </span>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <h4 class="kt-section__title">{{ __('Senior High School') }}</h4>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-4">
                                    <label for="nama_sma">{{ __('School Name') }}</label>
                                    <input id="nama_sma" type="text" class="form-control @error('nama_sma') is-invalid @enderror" name="nama_sma" value="{{ old('nama_sma', $data['nama_sma']) }}">

                                    @error('nama_sma')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="kota_sma">{{ __('City') }} / {{ __('Regency') }}</label>
                                    <select id="kota_sma" name="kota_sma" class="form-control kt_selectpicker @error('kota_sma') is-invalid @enderror" data-live-search="true" title="{{ __('Choose') }} {{ __('City') }} / {{ __('Regency') }}">
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" {{ old('kota_sma', $data['kota_sma']) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('kota_sma')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-3">
                                    <label for="jurusan_sma">{{ __('Majors') }}</label>
                                    <input id="jurusan_sma" type="text" class="form-control @error('jurusan_sma') is-invalid @enderror" name="jurusan_sma" value="{{ old('jurusan_sma', $data['jurusan_sma']) }}">

                                    @error('jurusan_sma')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="tahun_masuk_sma">{{ __('Year of Entry') }}</label>
                                    <input id="tahun_masuk_sma" type="text" class="form-control @error('tahun_masuk_sma') is-invalid @enderror" name="tahun_masuk_sma" value="{{ old('tahun_masuk_sma', $data['tahun_masuk_sma']) }}">

                                    @error('tahun_masuk_sma')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="tahun_keluar_sma">{{ __('Year Out') }}</label>
                                    <input id="tahun_keluar_sma" type="text" class="form-control @error('tahun_keluar_sma') is-invalid @enderror" name="tahun_keluar_sma" value="{{ old('tahun_keluar_sma', $data['tahun_keluar_sma']) }}">

                                    @error('tahun_keluar_sma')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-1">
                                    <label for="lulus_sma">{{ __('Graduate') }}</label><br>
                                    <span class="kt-switch kt-switch--sm kt-switch--icon kt-switch--primary kt-switch--outline">
                                        <label class="mb-0">
                                            <input type="checkbox" id="lulus_sma" name="lulus_sma" {{ old('lulus_sma', true) ? 'checked' : '' }}>
                                            <span class="m-0"></span>
                                        </label>
                                    </span>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <h4 class="kt-section__title">{{ __('Academy/University') }}</h4>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-4">
                                    <label for="nama_kampus">{{ __('Campus Name') }}</label>
                                    <input id="nama_kampus" type="text" class="form-control @error('nama_kampus') is-invalid @enderror" name="nama_kampus" value="{{ old('nama_kampus', $data['nama_kampus']) }}">

                                    @error('nama_kampus')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="kota_kampus">{{ __('City') }} / {{ __('Regency') }}</label>
                                    <select id="kota_kampus" name="kota_kampus" class="form-control kt_selectpicker @error('kota_kampus') is-invalid @enderror" data-live-search="true" title="{{ __('Choose') }} {{ __('City') }} / {{ __('Regency') }}">
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" {{ old('kota_kampus', $data['kota_kampus']) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('kota_kampus')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-3">
                                    <label for="jurusan_kuliah">{{ __('Majors') }}</label>
                                    <input id="jurusan_kuliah" type="text" class="form-control @error('jurusan_kuliah') is-invalid @enderror" name="jurusan_kuliah" value="{{ old('jurusan_kuliah', $data['jurusan_kuliah']) }}">

                                    @error('jurusan_kuliah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="tahun_masuk_kuliah">{{ __('Year of Entry') }}</label>
                                    <input id="tahun_masuk_kuliah" type="text" class="form-control @error('tahun_masuk_kuliah') is-invalid @enderror" name="tahun_masuk_kuliah" value="{{ old('tahun_masuk_kuliah', $data['tahun_masuk_kuliah']) }}">

                                    @error('tahun_masuk_kuliah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="tahun_keluar_kuliah">{{ __('Year Out') }}</label>
                                    <input id="tahun_keluar_kuliah" type="text" class="form-control @error('tahun_keluar_kuliah') is-invalid @enderror" name="tahun_keluar_kuliah" value="{{ old('tahun_keluar_kuliah', $data['tahun_keluar_kuliah']) }}">

                                    @error('tahun_keluar_kuliah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-1">
                                    <label for="lulus_kuliah">{{ __('Graduate') }}</label><br>
                                    <span class="kt-switch kt-switch--sm kt-switch--icon kt-switch--primary kt-switch--outline">
                                        <label class="mb-0">
                                            <input type="checkbox" id="lulus_kuliah" name="lulus_kuliah" {{ old('lulus_kuliah', true) ? 'checked' : 'uncheck' }}>
                                            <span class="m-0"></span>
                                        </label>
                                    </span>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <h4 class="kt-section__title">{{ __('Advanced') }}</h4>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-4">
                                    <label for="nama_lanjutan">{{ __('Campus Name') }}</label>
                                    <input id="nama_lanjutan" type="text" class="form-control @error('nama_lanjutan') is-invalid @enderror" name="nama_lanjutan" value="{{ old('nama_lanjutan', $data['nama_lanjutan']) }}">

                                    @error('nama_lanjutan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="kota_lanjutan">{{ __('City') }} / {{ __('Regency') }}</label>
                                    <select id="kota_lanjutan" name="kota_lanjutan" class="form-control kt_selectpicker @error('kota_lanjutan') is-invalid @enderror" data-live-search="true" title="{{ __('Choose') }} {{ __('City') }} / {{ __('Regency') }}">
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" {{ old('kota_lanjutan', $data['kota_lanjutan']) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('kota_lanjutan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-3">
                                    <label for="jurusan_lanjutan">{{ __('Majors') }}</label>
                                    <input id="jurusan_lanjutan" type="text" class="form-control @error('jurusan_lanjutan') is-invalid @enderror" name="jurusan_lanjutan" value="{{ old('jurusan_lanjutan', $data['jurusan_lanjutan']) }}">

                                    @error('jurusan_lanjutan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="tahun_masuk_lanjutan">{{ __('Year of Entry') }}</label>
                                    <input id="tahun_masuk_lanjutan" type="text" class="form-control @error('tahun_masuk_lanjutan') is-invalid @enderror" name="tahun_masuk_lanjutan" value="{{ old('tahun_masuk_lanjutan', $data['tahun_masuk_lanjutan']) }}">

                                    @error('tahun_masuk_lanjutan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="tahun_keluar_lanjutan">{{ __('Year Out') }}</label>
                                    <input id="tahun_keluar_lanjutan" type="text" class="form-control @error('tahun_keluar_lanjutan') is-invalid @enderror" name="tahun_keluar_lanjutan" value="{{ old('tahun_keluar_lanjutan', $data['tahun_keluar_lanjutan']) }}">

                                    @error('tahun_keluar_lanjutan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-1">
                                    <label for="lulus_lanjutan">{{ __('Graduate') }}</label><br>
                                    <span class="kt-switch kt-switch--sm kt-switch--icon kt-switch--primary kt-switch--outline">
                                        <label class="mb-0">
                                            <input type="checkbox" id="lulus_lanjutan" name="lulus_lanjutan" value={{ $data['lulus_lanjutan'] == 'Lulus' ? 'checked' : 'not checked' }}>
                                            <span class="m-0"></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group col-lg-8">
                            <div class="kt-form__actions">
                                <a href="{{ route('recruitment.register.step-2', $id) }}" class="btn btn-outline-brand btn-md btn-tall btn-wide btn-bold btn-upper">
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
    <script type="text/javascript">
        $('.kt_selectpicker').selectpicker({
            noneResultsText: "{{ __('No matching results for') }} {0}"
        });
    </script>
@endsection