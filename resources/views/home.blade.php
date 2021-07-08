@extends('layouts.app')

@section('title')
    {{ __('Dashboard') }} | {{ config('app.name') }}
@endsection

@section('subheader')
    {{ __('Dashboard') }}
@endsection

@section('content')
<div class="kt-portlet">
    <div class="kt-portlet__body">
        <div class="kt-portlet__content">
            @include('layouts.inc.alert')
            {{ __('You are logged in!') }}
        </div>
    </div>
</div>
@endsection
