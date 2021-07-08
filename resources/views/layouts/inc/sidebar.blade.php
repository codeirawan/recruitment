<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">
    <div class="kt-aside__brand kt-grid__item " id="kt_aside_brand">
        <div class="kt-aside__brand-logo">
            <a href="{{ url('/') }}">
                <img alt="Logo" src="{{ asset('media/logos/bnet-logo-app.png') }}" />
            </a>
        </div>
        <div class="kt-aside__brand-tools">
            <button class="kt-aside__brand-aside-toggler kt-aside__brand-aside-toggler--left" id="kt_aside_toggler"><span></span></button>
        </div>
    </div>

    <div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
        <div id="kt_aside_menu" class="kt-aside-menu" data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
            <ul class="kt-menu__nav">
                <li class="kt-menu__item @if(Request::is('/')) kt-menu__item--here @endif" aria-haspopup="true">
                    <a href="{{ route('home') }}" class="kt-menu__link">
                        <i class="kt-menu__link-icon flaticon2-graphic"></i>
                        <span class="kt-menu__link-text">{{ __('Dashboard') }}</span>
                    </a>
                </li>
                <li class="kt-menu__item @if(Request::is('my-activity*')) kt-menu__item--here @endif" aria-haspopup="true">
                    <a href="{{ route('my-activity.index') }}" class="kt-menu__link">
                        <i class="kt-menu__link-icon fa fa-clipboard-list"></i>
                        <span class="kt-menu__link-text">{{ __('My Activity') }}</span>
                    </a>
                </li>

                @permission(['view-purchase', 'view-product', 'view-supplier', 'view-storage-transaction'])
                    <li class="kt-menu__section ">
                        <h4 class="kt-menu__section-text">{{ __('Product Management') }}</h4>
                        <i class="kt-menu__section-icon flaticon-more-v2"></i>
                    </li>
                @endpermission
                @permission('view-purchase')
                    <li class="kt-menu__item @if(Request::is('purchase*')) kt-menu__item--here @endif" aria-haspopup="true">
                        <a href="{{ route('purchase.index') }}" class="kt-menu__link">
                            <i class="kt-menu__link-icon fa fa-shopping-cart"></i>
                            <span class="kt-menu__link-text">{{ __('Purchase') }}</span>
                        </a>
                    </li>
                @endpermission
                @permission('view-storage-transaction')
                    <li class="kt-menu__item @if(Request::is('storage-transaction*')) kt-menu__item--here @endif" aria-haspopup="true">
                        <a href="{{ route('storage-transaction.index') }}" class="kt-menu__link">
                            <i class="kt-menu__link-icon fa fa-exchange-alt"></i>
                            <span class="kt-menu__link-text">{{ __('Storage Transaction') }}</span>
                        </a>
                    </li>
                @endpermission
                @permission('view-product')
                    <li class="kt-menu__item @if(Request::is('product*')) kt-menu__item--here @endif" aria-haspopup="true">
                        <a href="{{ route('product.index') }}" class="kt-menu__link">
                            <i class="kt-menu__link-icon flaticon2-box-1"></i>
                            <span class="kt-menu__link-text">{{ __('Product') }}</span>
                        </a>
                    </li>
                @endpermission
                @permission('view-supplier')
                    <li class="kt-menu__item @if(Request::is('supplier*')) kt-menu__item--here @endif" aria-haspopup="true">
                        <a href="{{ route('supplier.index') }}" class="kt-menu__link">
                            <i class="kt-menu__link-icon fa fa-industry"></i>
                            <span class="kt-menu__link-text">{{ __('Supplier') }}</span>
                        </a>
                    </li>
                @endpermission

                @permission(['view-recruitment'])
                    <li class="kt-menu__section ">
                        <h4 class="kt-menu__section-text">{{ __('Employee Management') }}</h4>
                        <i class="kt-menu__section-icon flaticon-more-v2"></i>
                    </li>
                @endpermission
                @permission('view-recruitment')
                    <li class="kt-menu__item @if(Request::is('recruitment*')) kt-menu__item--here @endif" aria-haspopup="true">
                        <a href="{{ route('recruitment.index') }}" class="kt-menu__link">
                            <i class="kt-menu__link-icon fa fa-user-plus"></i>
                            <span class="kt-menu__link-text">{{ __('Recruitment') }}</span>
                        </a>
                    </li>
                @endpermission

                @permission(['view-user', 'view-role'])
                    <li class="kt-menu__section ">
                        <h4 class="kt-menu__section-text">{{ __('User Management') }}</h4>
                        <i class="kt-menu__section-icon flaticon-more-v2"></i>
                    </li>
                @endpermission
                @permission('view-user')
                    <li class="kt-menu__item @if(Request::is('user*')) kt-menu__item--here @endif" aria-haspopup="true">
                        <a href="{{ route('user.index') }}" class="kt-menu__link">
                            <i class="kt-menu__link-icon flaticon2-user"></i>
                            <span class="kt-menu__link-text">{{ __('User') }}</span>
                        </a>
                    </li>
                @endpermission
                @permission('view-role')
                    <li class="kt-menu__item @if(Request::is('role*')) kt-menu__item--here @endif" aria-haspopup="true">
                        <a href="{{ route('role.index') }}" class="kt-menu__link">
                            <i class="kt-menu__link-icon flaticon2-user-1"></i>
                            <span class="kt-menu__link-text">{{ __('Role') }}</span>
                        </a>
                    </li>
                @endpermission

                @permission(['view-product-category', 'view-product-unit', 'view-payment-method', 'view-position', 'view-resume-source', 'view-file-type'])
                    <li class="kt-menu__section ">
                        <h4 class="kt-menu__section-text">{{ __('Master Data Management') }}</h4>
                        <i class="kt-menu__section-icon flaticon-more-v2"></i>
                    </li>
                    <li class="kt-menu__item kt-menu__item--submenu @if(Request::is('master*')) kt-menu__item--open kt-menu__item--here @endif" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                            <i class="kt-menu__link-icon flaticon2-layers-1"></i>
                            <span class="kt-menu__link-text">{{ __('Master Data') }}</span>
                            <i class="kt-menu__ver-arrow la la-angle-right"></i>
                        </a>
                        <div class="kt-menu__submenu">
                            <span class="kt-menu__arrow"></span>
                            <ul class="kt-menu__subnav">
                                <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
                                    <span class="kt-menu__link">
                                        <span class="kt-menu__link-text">{{ __('Master Data') }}</span>
                                    </span>
                                </li>
                                @permission('view-product-category')
                                    <li class="kt-menu__item @if(Request::is('master/product-category*')) kt-menu__item--here @endif" aria-haspopup="true">
                                        <a href="{{ route('master.product-category.index') }}" class="kt-menu__link">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                            <span class="kt-menu__link-text">{{ __('Product Category') }}</span>
                                        </a>
                                    </li>
                                @endpermission
                                @permission('view-product-unit')
                                    <li class="kt-menu__item @if(Request::is('master/product-unit*')) kt-menu__item--here @endif" aria-haspopup="true">
                                        <a href="{{ route('master.product-unit.index') }}" class="kt-menu__link">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                            <span class="kt-menu__link-text">{{ __('Product Unit') }}</span>
                                        </a>
                                    </li>
                                @endpermission
                                @permission('view-payment-method')
                                    <li class="kt-menu__item @if(Request::is('master/payment-method*')) kt-menu__item--here @endif" aria-haspopup="true">
                                        <a href="{{ route('master.payment-method.index') }}" class="kt-menu__link">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                            <span class="kt-menu__link-text">{{ __('Payment Method') }}</span>
                                        </a>
                                    </li>
                                @endpermission
                                @permission('view-position')
                                    <li class="kt-menu__item @if(Request::is('master/position*')) kt-menu__item--here @endif" aria-haspopup="true">
                                        <a href="{{ route('master.position.index') }}" class="kt-menu__link">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                            <span class="kt-menu__link-text">{{ __('Position') }}</span>
                                        </a>
                                    </li>
                                @endpermission
                                @permission('view-resume-source')
                                    <li class="kt-menu__item @if(Request::is('master/resume-source*')) kt-menu__item--here @endif" aria-haspopup="true">
                                        <a href="{{ route('master.resume-source.index') }}" class="kt-menu__link">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                            <span class="kt-menu__link-text">{{ __('Resume Source') }}</span>
                                        </a>
                                    </li>
                                @endpermission
                                @permission('view-file-type')
                                    <li class="kt-menu__item @if(Request::is('master/file-type*')) kt-menu__item--here @endif" aria-haspopup="true">
                                        <a href="{{ route('master.file-type.index') }}" class="kt-menu__link">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                            <span class="kt-menu__link-text">{{ __('File Type') }}</span>
                                        </a>
                                    </li>
                                @endpermission
                            </ul>
                        </div>
                    </li>
                @endpermission
            </ul>
        </div>
    </div>
</div>