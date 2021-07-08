@extends('layouts.app')

@section('title')
    {{ __('Create') }} {{ __('Supplier') }} | {{ config('app.name') }}
@endsection

@section('style')
    <link href="{{ asset(mix('css/datatable.css')) }}" rel="stylesheet">
@endsection

@section('subheader')
    {{ __('Create') }} {{ __('Supplier') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('supplier.index') }}" class="kt-subheader__breadcrumbs-link">{{ __('Supplier') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('supplier.create') }}" class="kt-subheader__breadcrumbs-link">{{ __('Create') }} {{ __('Supplier') }}</a>
@endsection

@section('content')
<form class="kt-form" id="kt_form_1" action="{{ route('supplier.store') }}" method="POST">
    @csrf

    <div class="kt-portlet" id="kt_page_portlet">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">{{ __('Create') }} {{ __('Supplier') }}</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <a href="{{ route('supplier.index') }}" class="btn btn-secondary kt-margin-r-10">
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
                            <label for="nama">{{ __('Name') }}</label>
                            <input id="nama" name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" required value="{{ old('nama') }}">

                            @error('nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="jenis">{{ __('Type') }}</label>
                            <select id="jenis" name="jenis" class="form-control kt_selectpicker @error('jenis') is-invalid @enderror" required data-live-search="true" title="{{ __('Choose') }} {{ __('Type') }}">
                                <option value="Individual" {{ old('jenis') == 'Individual' ? 'selected' : '' }}>{{ __('Individual') }}</option>
                                <option value="PT" {{ old('jenis') == 'PT' ? 'selected' : '' }}>PT</option>
                                <option value="CV" {{ old('jenis') == 'CV' ? 'selected' : '' }}>CV</option>
                            </select>

                            @error('jenis')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="nomor_telepon">{{ __('Telephone Number') }}</label>
                            <input id="nomor_telepon" name="nomor_telepon" type="text" class="form-control @error('nomor_telepon') is-invalid @enderror" required value="{{ old('nomor_telepon') }}">

                            @error('nomor_telepon')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="npwp">NPWP</label>
                            <input id="npwp" name="npwp" type="text" class="form-control @error('npwp') is-invalid @enderror" required value="{{ old('npwp') }}">

                            @error('npwp')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="alamat">{{ __('Address') }}</label>
                            <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat') }}</textarea>

                            @error('alamat')
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
                        <div class="form-group col-sm-5">
                            <label for="kategori">{{ __('Category') }}</label>
                            <select id="kategori" class="form-control kt_selectpicker" data-live-search="true" title="{{ __('Choose') }} {{ __('Category') }}">
                                @foreach ($productCategories as $productCategory)
                                    <option value="{{ $productCategory->id }}">{{ $productCategory->name }} ({{ $productCategory->code }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-5">
                            <label for="barang">{{ __('Product') }}</label>
                            <select id="barang" class="form-control kt_selectpicker" data-live-search="true" title="{{ __('Choose') }} {{ __('Product') }}">
                            </select>
                        </div>

                        <div class="form-group col-sm-2">
                            <button type="button" class="btn btn-primary btn-block btn-input" id="btn-add">
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
    <script src="{{ asset(mix('js/datatable.js')) }}"></script>
    <script src="{{ asset(mix('js/tooltip.js')) }}"></script>
    <script src="{{ asset(mix('js/form/validation.js')) }}"></script>
    <script type="text/javascript">
        $('.kt_selectpicker').selectpicker({
            noneResultsText: "{{ __('No matching results for') }} {0}"
        });

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
                { title: "{{ __('Category') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Action') }}", defaultContent: '-', class: 'text-center' },
                { title: "Product ID", visible: false },
            ],
            drawCallback: function() {
                $('.btn-tooltip').tooltip();
            }
        });

        getProducts();

        $('#kategori').change(function() {
            getProducts();
        });

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

            if (!category) {
                @include('layouts.inc.sweetalert', ['title' => 'Error', 'text' => Lang::get('The category field is required.')])
                return;
            }
            if (!product) {
                @include('layouts.inc.sweetalert', ['title' => 'Error', 'text' => Lang::get('The product field is required.')])
                return;
            }

            var rowLength = table.column( 0 ).data().length;
            for (var i = 0; i < rowLength; i++) {
                var productId = table.cell(i, 5).data();

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
                $('#kategori').find(":selected").text(),
                '<a id="btn-delete" href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="{{ __('Delete')}}"><i class="la la-trash"></i></a>' + '<input type="hidden" name="barang[' + productCount + ']" value="' + product + '">',
                product
            ]).draw(false);

            productCount++;
        });

        $('#kt_table_1 tbody').on('click', '#btn-delete', function() {
            table.row($(this).parents('tr')).remove().draw();
        });
    </script>
@endsection