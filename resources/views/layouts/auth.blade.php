@extends('layouts.master')

@section('style')
    <link href="{{ asset(mix('css/auth.css')) }}" rel="stylesheet">
@endsection

@section('body')
<body class="kt-login-v2--enabled kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--fixed kt-page--loading">
    <div class="kt-grid kt-grid--ver kt-grid--root">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid kt-grid--hor kt-login-v2" id="kt_login_v2">
            <div class="kt-grid__item kt-grid--hor">
                <div class="kt-login-v2__head">
                    <div class="kt-login-v2__logo">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('media/logos/bnet-logo-auth.png') }}" alt="" />
                        </a>
                    </div>
                    @yield('navbar')
                </div>
            </div>

            <div class="kt-grid__item kt-grid kt-grid--ver kt-grid__item--fluid">
                <div class="kt-login-v2__body">
                    <div class="kt-login-v2__wrapper">
                        <div class="kt-login-v2__container">
                            <div class="kt-login-v2__title">
                                <h3>@yield('header')</h3>
                            </div>

                            <form method="POST" class="kt-login-v2__form kt-form" autocomplete="off" id="kt_login_form">
                                @csrf
                                @yield('content')
                            </form>

                            @yield('footer')
                        </div>
                    </div>

                    <div class="kt-login-v2__image">
                        <img src="{{ asset('media/misc/bg_icon.svg') }}" alt="">
                    </div>
                </div>
            </div>

            <div class="kt-grid__item">
                <div class="kt-login-v2__footer">
                    <div class="kt-login-v2__info">
                        &copy; 2019 <a href="https://bnet.id" target="_blank" class="kt-link">Bnet</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.inc.scripts')
    <script src="{{ asset(mix('js/auth.js')) }}"></script>
</body>
@endsection