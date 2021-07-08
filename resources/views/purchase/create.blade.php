@extends('layouts.app')

@section('title')
    {{ __('Create') }} {{ __('Purchase') }} | {{ config('app.name') }}
@endsection

@section('style')
    <link href="{{ asset(mix('css/datatable.css')) }}" rel="stylesheet">
@endsection

@section('subheader')
    {{ __('Create') }} {{ __('Purchase') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ ('purchase.index') }}" class="kt-subheader__breadcrumbs-link">{{ __('Purchase') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ ('purchase.create') }}" class="kt-subheader__breadcrumbs-link">{{ __('Create') }} {{ __('Purchase') }}</a>
@endsection

@section('content')
<form class="kt-form" id="kt_form_1" action="{{ ('purchase.store') }}" method="POST">
    @csrf

    <div class="kt-portlet" id="kt_page_portlet">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">{{ __('Create') }} {{ __('Purchase') }}</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <a href="{{ ('purchase.index') }}" class="btn btn-secondary kt-margin-r-10">
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
                            <label for="pemasok">{{ __('Supplier') }}</label>
                            <select id="pemasok" name="pemasok" class="form-control kt_selectpicker @error('pemasok') is-invalid @enderror" required data-live-search="true" title="{{ __('Choose') }} {{ __('Supplier') }}">
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('pemasok') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                @endforeach
                            </select>

                            @error('pemasok')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="metode_pembayaran">{{ __('Payment Method') }}</label>
                            <select id="metode_pembayaran" name="metode_pembayaran" class="form-control kt_selectpicker @error('metode_pembayaran') is-invalid @enderror" required data-live-search="true" title="{{ __('Choose') }} {{ __('Payment Method') }}">
                                @foreach ($paymentMethods as $paymentMethod)
                                    <option value="{{ $paymentMethod->id }}" {{ old('metode_pembayaran') == $paymentMethod->id ? 'selected' : '' }}>{{ $paymentMethod->name }}</option>
                                @endforeach
                            </select>

                            @error('metode_pembayaran')
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
        <div class="kt-portlet__foot">
            <div class="kt-section kt-section--first">
                <h3 class="kt-section__title">{{ __('Product List') }}</h3>

                <div class="kt-section__body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="kategori">{{ __('Category') }}</label>
                            <select id="kategori" class="form-control kt_selectpicker" data-live-search="true" title="{{ __('Choose') }} {{ __('Category') }}">
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="barang">{{ __('Product') }}</label>
                            <select id="barang" class="form-control kt_selectpicker" data-live-search="true" title="{{ __('Choose') }} {{ __('Product') }}">
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="jumlah">{{ __('Quantity') }}</label>
                            <input id="jumlah" type="text" class="form-control separator">
                            <input id="hidden-jumlah" type="hidden" class="separator-hidden">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="harga">{{ __('Price') }}</label>
                            <input id="harga" type="text" class="form-control separator currency">
                            <input id="hidden-harga" type="hidden" class="separator-hidden">
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="catatan_barang">{{ __('Note') }}</label>
                            <textarea id="catatan_barang" class="form-control"></textarea>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="garansi">{{ __('Warranty') }}</label><br>
                            <span class="kt-switch kt-switch--sm kt-switch--icon kt-switch--primary kt-switch--outline">
                                <label class="mb-0">
                                    <input type="checkbox" id="garansi">
                                    <span class="m-0"></span>
                                </label>
                            </span>
                        </div>

                        <div class="form-group col-sm-6 warranty" hidden>
                            <label for="tanggal_kedaluwarsa_garansi">{{ __('Warranty Expiration Date') }}</label><br>
                            <input id="tanggal_kedaluwarsa_garansi" type="text" class="form-control" readonly>
                        </div>

                        <div class="form-group col-sm-12 warranty" hidden>
                            <label for="syarat_dan_ketentuan_garansi">{{ __('Warranty Terms and Conditions') }}</label>
                            <textarea id="syarat_dan_ketentuan_garansi" class="form-control"></textarea>
                        </div>

                        <div class="form-group col-sm-12">
                            <button type="button" class="btn btn-primary btn-block" id="btn-add">
                                <i class="la la-plus"></i>
                                <span class="kt-hidden-mobile">{{ __('Add') }}</span>
                            </button>
                        </div>

                        <div class="form-group col-sm-12">
                            <table class="table table-striped- table-bordered table-hover" id="kt_table_1"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('script')
    @include('layouts.inc.thousand-separator')

    <script src="{{ asset(mix('js/datatable.js')) }}"></script>
    <script src="{{ asset(mix('js/tooltip.js')) }}"></script>
    <script src="{{ asset(mix('js/form/validation.js')) }}"></script>
    <script type="text/javascript">
        $('.kt_selectpicker').selectpicker({
            noneResultsText: "{{ __('No matching results for') }} {0}"
        });

        $('#tanggal_kedaluwarsa_garansi').datepicker({
            autoclose: true,
            clearBtn: true,
            disableTouchKeyboard: true,
            format: "dd-mm-yyyy",
            language: "{{ config('app.locale') }}",
            startDate: "0d",
            templates: {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            },
            todayBtn: "linked",
            todayHighlight: true
        });

        toggleWarranty();

        $('#garansi').change(function() {
            toggleWarranty();
        });

        function toggleWarranty() {
            if ($('#garansi').is(':checked')) $('.warranty').removeAttr('hidden');
            else $('.warranty').attr('hidden', '');
        }

        var table = $('#kt_table_1').DataTable({
            processing: true,
            serverSide: false,
            responsive: true,
            paging: false,
            ordering: false,
            searching: false,
            language: {
                emptyTable: "{{ __('No data available in table') }}",
                info: "{{ __('Showing _START_ to _END_ of _TOTAL_ entries') }}",
                infoEmpty: "{{ __('Showing 0 to 0 of 0 entries') }}",
                infoFiltered: "({{ __('filtered from _MAX_ total entries') }})",
                lengthMenu: "{{ __('Show _MENU_ entries') }}",
                loadingRecords: "{{ __('Loading') }}...",
                processing: "{{ __('Processing') }}...",
                search: "{{ __('Search') }}",
                zeroRecords: "{{ __('No matching records found') }}"
            },
            columns: [
                { title: "{{ __('Photo') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Code') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Name') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Quantity') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Price') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Note') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Warranty') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Action') }}", defaultContent: '-', class: 'text-center' },
                { title: "Product ID", visible: false },
            ],
            drawCallback: function() {
                $('.btn-tooltip').tooltip();
            }
        });

        getProductCategories();
        getProducts();

        $('#pemasok').change(function() {
            getProductCategories();
        });

        $('#kategori').change(function() {
            getProducts();
        });

        function getProductCategories() {
            var supplierId = $('#pemasok').val();

            $('.product-category-data').remove();

            if (supplierId) {
                $.ajax({
                    url: "{{ url('/api/supplier') }}/" + supplierId + "/product-category",
                    success: function(data) {
                        $.each(data.data, function(i, data){
                            $('#kategori').append($('<option>', {value: data.id, text: data.name + ' (' + data.code + ')'}).addClass('product-category-data'));
                        });

                        $('#kategori').selectpicker('refresh');
                    }
                });
            }
        }

        function getProducts() {
            var categoryId = $('#kategori').val();

            $('.product-data').remove();

            if (categoryId) {
                $.ajax({
                    url: "{{ url('/api/product-category') }}/" + categoryId + "/product",
                    success: function(data) {
                        $.each(data.data, function(i, data){
                            $('#barang').append($('<option>', {value: data.id, text: data.name}).attr('data-content', '<a class="kt-media kt-media--xl"><img src="' + data.photo + '"></a> ' + data.name + ' (' + data.code + ')').attr('data-photo', data.photo).attr('data-code', data.code).addClass('product-data'));
                        });

                        $('#barang').selectpicker('refresh');
                    }
                });
            }
        }

        var productCount = 0;

        $('#btn-add').click(function() {
            var category = $('#kategori').val();
            var product = $('#barang').val();
            var quantity = parseInt($('#hidden-jumlah').val());
            var price = parseFloat($('#hidden-harga').val());
            var note = $('#catatan_barang').val();
            var guaranteed = 0;
            var warranty = '<i class="la la-times text-danger font-weight-bold"></i>';
            var warrantyEndDate = $('#tanggal_kedaluwarsa_garansi').val();
            var warrantyTnC = $('#syarat_dan_ketentuan_garansi').val();

            if (!category) {
                @include('layouts.inc.sweetalert', ['title' => 'Error', 'text' => Lang::get('The category field is required.')])
                return;
            }
            if (!product) {
                @include('layouts.inc.sweetalert', ['title' => 'Error', 'text' => Lang::get('The product field is required.')])
                return;
            }
            if (!quantity) {
                @include('layouts.inc.sweetalert', ['title' => 'Error', 'text' => Lang::get('The quantity field is required.')])
                return;
            }
            if (quantity < 1) {
                @include('layouts.inc.sweetalert', ['title' => 'Error', 'text' => Lang::get('The quantity must be at least 1.')])
                return;
            }
            if (!price && price != 0) {
                @include('layouts.inc.sweetalert', ['title' => 'Error', 'text' => Lang::get('The price field is required.')])
                return;
            }
            if (price < 0) {
                @include('layouts.inc.sweetalert', ['title' => 'Error', 'text' => Lang::get('The price must be at least 0.')])
                return;
            }
            if (!note) {
                @include('layouts.inc.sweetalert', ['title' => 'Error', 'text' => Lang::get('The note field is required.')])
                return;
            }
            if ($('#garansi').is(':checked')) {
                if (!warrantyEndDate) {
                    @include('layouts.inc.sweetalert', ['title' => 'Error', 'text' => Lang::get('The warranty expiration date field is required.')])
                    return;
                }
                if (!warrantyTnC) {
                    @include('layouts.inc.sweetalert', ['title' => 'Error', 'text' => Lang::get('The warranty terms & conditions field is required.')])
                    return;
                }

                guaranteed = 1;
                warranty = '<i class="la la-clock-o btn-tooltip" title="{{ __('Warranty Expiration Date') }}"></i> ' + warrantyEndDate + '<br><i class="la la-file-text btn-tooltip" title="{{ __('Warranty Terms and Conditions') }}"></i> ' + warrantyTnC;
            }

            var rowLength = table.column( 0 ).data().length;
            for (var i = 0; i < rowLength; i++) {
                var productId = table.cell(i, 8).data();

                if (productId == product) {
                    @include('layouts.inc.sweetalert', ['title' => 'Error', 'text' => Lang::get('This product is already on the list.')])
                    return;
                }
            }

            var photo = $('#barang').find(":selected").data('photo');

            table.row.add([
                '<a href="' + photo + '" class="kt-media kt-media--xl" target="_blank"><img src="' + photo + '"></a>',
                $('#barang').find(":selected").data('code'),
                $('#barang').find(":selected").text(),
                numberWithCommas(quantity),
                'Rp' + numberWithCommas(price),
                note,
                warranty,
                '<a id="btn-delete" href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="{{ __('Delete')}}"><i class="la la-trash"></i></a>' + '<input type="hidden" name="barang[' + productCount + '][id]" value="' + product + '">' + '<input type="hidden" name="barang[' + productCount + '][harga]" value="' + price + '">' + '<input type="hidden" name="barang[' + productCount + '][jumlah]" value="' + quantity + '">' + '<input type="hidden" name="barang[' + productCount + '][catatan]" value="' + note + '">' + '<input type="hidden" name="barang[' + productCount + '][garansi]" value="' + guaranteed + '">' + '<input type="hidden" name="barang[' + productCount + '][tanggal_kedaluwarsa_garansi]" value="' + warrantyEndDate + '">' + '<input type="hidden" name="barang[' + productCount + '][syarat_dan_ketentuan_garansi]" value="' + warrantyTnC + '">',
                product
            ]).draw(false);

            productCount++;
        });

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        $('#kt_table_1 tbody').on('click', '#btn-delete', function() {
            table.row($(this).parents('tr')).remove().draw();
        });
    </script>
@endsection