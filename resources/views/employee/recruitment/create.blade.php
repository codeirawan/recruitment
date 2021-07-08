@extends('layouts.app')

@section('title')
    {{ __('Create') }} {{ __('Recruitment') }} | {{ config('app.name') }}
@endsection

@section('subheader')
    {{ __('Create') }} {{ __('Recruitment') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('recruitment.index') }}" class="kt-subheader__breadcrumbs-link">{{ __('Recruitment') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('recruitment.create') }}" class="kt-subheader__breadcrumbs-link">{{ __('Create') }} {{ __('Recruitment') }}</a>
@endsection

@section('content')
<form class="kt-form" id="kt_form_1" action="{{ route('recruitment.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="kt-portlet" id="kt_page_portlet">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">{{ __('Create') }} {{ __('Recruitment') }}</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <a href="{{ route('recruitment.index') }}" class="btn btn-secondary kt-margin-r-10">
                    <i class="la la-arrow-left"></i>
                    <span class="kt-hidden-mobile">{{ __('Back') }}</span>
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="la la-check"></i>
                    <span class="kt-hidden-mobile">{{ __('Save') }}</span>
                </button>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="kt-section kt-section--first">
                <div class="kt-section__body">
                    @include('layouts.inc.alert')

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="nama">{{ __('Name') }}</label>
                            <input id="nama" name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" required value="{{ old('nama') }}">

                            @error('nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="email">{{ __('Email') }}</label>
                            <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" required value="{{ old('email') }}">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="nomor_telepon">{{ __('Phone Number') }}</label>
                            <input id="nomor_telepon" name="nomor_telepon" type="text" class="form-control @error('nomor_telepon') is-invalid @enderror" value="{{ old('nomor_telepon') }}">

                            @error('nomor_telepon')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="cv">{{ __('Resume') }}</label><br>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('cv') is-invalid @enderror" id="cv" name="cv" accept="application/pdf" required>

                                @error('cv')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <label class="custom-file-label" for="cv">{{ __('Choose') }} {{ __('Resume') }}</label>
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="sumber_cv">{{ __('Resume Source') }}</label>
                            <select id="sumber_cv" name="sumber_cv" class="form-control kt_selectpicker @error('sumber_cv') is-invalid @enderror" required data-live-search="true" title="{{ __('Choose') }} {{ __('Resume Source') }}">
                                @foreach ($resumeSources as $resumeSource)
                                    <option value="{{ $resumeSource->id }}" {{ old('sumber_cv') == $resumeSource->id ? 'selected' : '' }}>{{ $resumeSource->name }}</option>
                                @endforeach
                            </select>

                            @error('sumber_cv')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="jabatan">{{ __('Position') }}</label>
                            <select id="jabatan" name="jabatan" class="form-control kt_selectpicker @error('jabatan') is-invalid @enderror" required data-live-search="true" title="{{ __('Choose') }} {{ __('Position') }}">
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}" {{ old('jabatan') == $position->id ? 'selected' : '' }}>{{ $position->name }}</option>
                                @endforeach
                            </select>

                            @error('jabatan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="kota">{{ __('City') . ' / ' . __('Regency') }}</label>
                            <select id="kota" name="kota" class="form-control kt_selectpicker @error('kota') is-invalid @enderror" required data-live-search="true" title="{{ __('Choose') }} {{ __('City') }} / {{ __('Regency') }}">
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" {{ old('city') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            </select>

                            @error('kota')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="catatan">{{ __('Note') }}</label>
                            <textarea id="catatan" name="catatan" class="form-control @error('catatan') is-invalid @enderror">{{ old('catatan') }}</textarea>

                            @error('catatan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('script')
    <script src="{{ asset(mix('js/form/validation.js')) }}"></script>
    <script type="text/javascript">
        $('.kt_selectpicker').selectpicker({
            noneResultsText: "{{ __('No matching results for') }} {0}"
        });
    </script>
@endsection