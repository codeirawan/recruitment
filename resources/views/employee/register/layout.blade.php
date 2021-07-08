@extends('layouts.master')

@section('body')
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">
    <div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
        <div class="kt-header-mobile__logo w-100">
            <a class="w-100 text-center" href="https://bnet.id">
                <img alt="Logo" src="{{ asset('media/logos/bnet-logo-app-mobile.png') }}" />
            </a>
        </div>
    </div>

    <div class="kt-grid kt-grid--hor kt-grid--root">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
                <div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">
                    <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>

                    <div class="kt-header-menu-wrapper w-100" id="kt_header_menu_wrapper">
                        <div class="kt-header-logo w-100">
                            <a class="w-100 text-center" href="https://bnet.id">
                                <img alt="Logo" src="{{ asset('media/logos/bnet-logo-app.png') }}" />
                            </a>
                        </div>
                    </div>
                </div>

                <div class="kt-content kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                    <div class="kt-subheader kt-grid__item" id="kt_subheader">
                        <div class="kt-container kt-container--fluid ">
                            <div class="kt-subheader__main w-100">
                                <h3 class="kt-subheader__title w-100 text-center">@yield('subheader')</h3>
                            </div>
                        </div>
                    </div>

                    <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="kt_scrolltop" class="kt-scrolltop">
        <i class="la la-arrow-up"></i>
    </div>

    @include('layouts.inc.scripts')
</body>
@endsection