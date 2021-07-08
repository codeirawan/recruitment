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
                            <div class="kt-wizard-v1__nav-item-title">{{ __('Reading Activities') }}</div>
                            <div class="kt-wizard-v1__nav-item-desc">{{ __('This form must be filled in completely. Incomplete filling will affect the processing of your application.')}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">
                <form class="kt-form" id="kt_form_1" action="{{ route('recruitment.register.step-8.validate', $id) }}" method="POST">
                    @csrf

                    <div class="kt-wizard-v1__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                        @include('layouts.inc.alert')
                                            
                        <div class="kt-separator kt-separator--height-xs"></div>
                        <div class="kt-form__section kt-form__section--first">

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-2">
                                    <label for="jumlah_bacaan">{{ __('How often do you read?') }}</label>
                                    <select class="form-control @error('jumlah_bacaan') is-invalid @enderror" id="jumlah_bacaan" name="jumlah_bacaan">
                                        <option value="A Lot" {{ old('jumlah_bacaan', $data['jumlah_bacaan']) == 'A Lot' ? 'selected' : '' }}>{{ __('A Lot') }}</option>
                                        <option value="Enough" {{ old('jumlah_bacaan', $data['jumlah_bacaan']) == 'Enough' ? 'selected' : '' }}>{{ __('Enough') }}</option>
                                        <option value="Little" {{ old('jumlah_bacaan', $data['jumlah_bacaan']) == 'Little' ? 'selected' : '' }}>{{ __('Little') }}</option>
                                    </select>

                                    @error('jumlah_bacaan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-3">
                                    <label for="topik_bacaan">{{ __('Topic of Reading') }}</label>
                                    <textarea id="topik_bacaan" type="text" class="form-control @error('topik_bacaan') is-invalid @enderror" name="topik_bacaan" value="{{ old('topik_bacaan', $data['topik_bacaan']) }}"></textarea>

                                    @error('topik_bacaan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-3">
                                    <label for="media_bacaan">{{ __('Media That is Often Read') }}</label>
                                    <textarea id="media_bacaan" type="text" class="form-control @error('media_bacaan') is-invalid @enderror" name="media_bacaan" value="{{ old('media_bacaan', $data['media_bacaan']) }}"></textarea>

                                    @error('media_bacaan')
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
                                <a href="{{ route('recruitment.register.step-7', $id) }}" class="btn btn-outline-brand btn-md btn-tall btn-wide btn-bold btn-upper">
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
@endsection