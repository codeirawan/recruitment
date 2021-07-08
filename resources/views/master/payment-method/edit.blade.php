@extends('layouts.app')

@section('title')
    {{ __('Edit') }} {{ __('Payment Method') }} | {{ config('app.name') }}
@endsection

@section('subheader')
    {{ __('Edit') }} {{ __('Payment Method') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('master.payment-method.index') }}" class="kt-subheader__breadcrumbs-link">{{ __('Payment Method') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('master.payment-method.edit', $paymentMethod->id) }}" class="kt-subheader__breadcrumbs-link">{{ $paymentMethod->name }}</a>
@endsection

@section('content')
<form class="kt-form" id="kt_form_1" action="{{ route('master.payment-method.update', $paymentMethod->id) }}" method="POST">
    @method('PUT')
    @csrf

    <div class="kt-portlet" id="kt_page_portlet">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">{{ __('Edit') }} {{ __('Payment Method') }}</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <a href="{{ route('master.payment-method.index') }}" class="btn btn-secondary kt-margin-r-10">
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

                    <div class="form-group">
                        <label for="nama">{{ __('Name') }}</label>
                        <input id="nama" name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" required value="{{ old('nama', $paymentMethod->name) }}">

                        @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('script')
    <script src="{{ asset(mix('js/form/validation.js')) }}"></script>
@endsection