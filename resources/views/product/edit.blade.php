@extends('layouts.app')

@section('title')
    {{ __('Edit') }} {{ __('Product') }} | {{ config('app.name') }}
@endsection

@section('subheader')
    {{ __('Edit') }} {{ __('Product') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{('product.index') }}" class="kt-subheader__breadcrumbs-link">{{ __('Product') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{('product.edit', $product->id) }}" class="kt-subheader__breadcrumbs-link">{{ $product->name }}</a>
@endsection

@section('content')
<form class="kt-form" id="kt_form_1" action="{{('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf

    <div class="kt-portlet" id="kt_page_portlet">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">{{ __('Edit') }} {{ __('Product') }}</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <a href="{{('product.index') }}" class="btn btn-secondary kt-margin-r-10">
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
                        <div class="form-group col-sm-6">
                            <label for="kode">{{ __('Code') }}</label>
                            <div class="input-group">
                                <div class="input-group-append"><span class="input-group-text">...</span></div>
                                <input id="kode" name="kode" type="text" class="form-control @error('kode') is-invalid @enderror" required value="{{ old('kode', explode($product->category_code, $product->code)[1]) }}">
                            </div>

                            @error('kode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="nama">{{ __('Name') }}</label>
                            <input id="nama" name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" required value="{{ old('nama', $product->name) }}">

                            @error('nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="kategori">{{ __('Category') }}</label>
                            <select id="kategori" name="kategori" class="form-control kt_selectpicker @error('kategori') is-invalid @enderror" required data-live-search="true" title="{{ __('Choose') }} {{ __('Category') }}">
                                @foreach ($productCategories as $productCategory)
                                    <option value="{{ $productCategory->id }}" data-code="{{ $productCategory->code }}" {{ old('kategori', $product->category_id) == $productCategory->id ? 'selected' : '' }}>{{ $productCategory->name }} ({{ $productCategory->code }})</option>
                                @endforeach
                            </select>

                            @error('kategori')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="satuan">{{ __('Unit') }}</label>
                            <select id="satuan" name="satuan" class="form-control kt_selectpicker @error('satuan') is-invalid @enderror" required data-live-search="true" title="{{ __('Choose') }} {{ __('Unit') }}">
                                @foreach ($productUnits as $productUnit)
                                    <option value="{{ $productUnit->id }}" {{ old('satuan', $product->unit_id) == $productUnit->id ? 'selected' : '' }}>{{ $productUnit->name }}</option>
                                @endforeach
                            </select>

                            @error('satuan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="foto">{{ __('Photo') }}</label><br>

                            <a href="{{ $product->photo }}" class="kt-media kt-media--xl" target="_blank">
                                <img src="{{ $product->photo }}">
                            </a>

                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*">

                                @error('foto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <label class="custom-file-label" for="foto">{{ __('Choose') }} {{ __('Photo') }}</label>
                            </div>
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="sku_per_satuan">{{ __('SKU per Unit') }}</label><br>
                            <span class="kt-switch kt-switch--sm kt-switch--icon kt-switch--primary kt-switch--outline">
                                <label class="mb-0">
                                    <input type="checkbox" id="sku_per_satuan" name="sku_per_satuan" {{ old('sku_per_satuan', $product->sku_per_unit) ? 'checked' : '' }}>
                                    <span class="m-0"></span>
                                </label>
                            </span>
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="alamat_mac">{{ __('MAC Address') }}</label><br>
                            <span class="kt-switch kt-switch--sm kt-switch--icon kt-switch--primary kt-switch--outline">
                                <label class="mb-0">
                                    <input type="checkbox" id="alamat_mac" name="alamat_mac" {{ old('alamat_mac', $product->mac_address) ? 'checked' : '' }}>
                                    <span class="m-0"></span>
                                </label>
                            </span>
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

        getCategoryCode();

        $('#kategori').change(function() {
            getCategoryCode();
        });

        function getCategoryCode() {
            $('.input-group-text').text($('#kategori').find(":selected").data('code'));
        }
    </script>
@endsection