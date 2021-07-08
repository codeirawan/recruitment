@extends('layouts.app')

@section('title')
    {{ __('Create') }} {{ __('Storage Transaction') }} | {{ config('app.name') }}
@endsection

@section('style')
    <link href="{{ asset(mix('css/datatable.css')) }}" rel="stylesheet">
@endsection

@section('subheader')
    {{ __('Create') }} {{ __('Storage Transaction') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('storage-transaction.index') }}" class="kt-subheader__breadcrumbs-link">{{ __('Storage Transaction') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('storage-transaction.create') }}" class="kt-subheader__breadcrumbs-link">{{ __('Create') }} {{ __('Storage Transaction') }}</a>
@endsection

@section('content')
<form class="kt-form" id="kt_form_1" action="{{ route('storage-transaction.store') }}" method="POST">
    @csrf

    <div class="kt-portlet" id="kt_page_portlet">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">{{ __('Create') }} {{ __('Storage Transaction') }}</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <a href="{{ route('storage-transaction.index') }}" class="btn btn-secondary kt-margin-r-10">
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
                            <label for="jenis">{{ __('Type') }}</label>
                            <select id="jenis" name="jenis" class="form-control kt_selectpicker @error('jenis') is-invalid @enderror" required data-live-search="true" title="{{ __('Choose') }} {{ __('Type') }}">
                                <option value="New" {{ old('jenis') == 'New' ? 'selected' : '' }}>{{ __('New') }}</option>
                            </select>

                            @error('jenis')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6 new">
                            <label for="nomor_pembelian">{{ __('Purchase Number') }}</label>
                            <div class="input-group">
                                <input id="nomor_pembelian" name="nomor_pembelian" type="text" class="form-control @error('nomor_pembelian') is-invalid @enderror" value="{{ old('nomor_pembelian') }}">
                                <div class="input-group-append">
                                    <button id="btn-search" type="button" class="btn btn-primary">
                                        <i class="la la-search kt-font-light p-0"></i>
                                    </button>
                                </div>
                            </div>

                            @error('nomor_pembelian')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__foot purchase-summary d-none">
            <div class="kt-section kt-section--first">
                <h3 class="kt-section__title">{{ __('Purchase Summary') }} <a id="purchase-details" target="_blank" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="{{ Lang::get('Purchase Details') }}" style="height: 17px; width: 17px;"><i class="la la-info-circle"></i></a></h3>

                <div class="kt-section__body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="nomor">{{ __('Number') }}</label>
                            <input id="nomor" type="text" class="form-control" disabled>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="total_harga">{{ __('Total Price') }}</label>
                            <input id="total_harga" type="text" class="form-control" disabled>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="pemasok">{{ __('Supplier') }}</label>
                            <input id="pemasok" type="text" class="form-control" disabled>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="metode_pembayaran">{{ __('Payment Method') }}</label>
                            <input id="metode_pembayaran" type="text" class="form-control" disabled>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="status_pembayaran">{{ __('Payment Status') }}</label>
                            <div class="input-group">
                                <input id="status_pembayaran" type="text" class="form-control" disabled>
                                <div class="input-group-append">
                                    <a id="proof-of-payment" class="btn btn-primary btn-tooltip" target="_blank" title="{{ __('View') . ' ' . __('Proof of Payment') }}">
                                        <i class="fa fa-eye kt-font-light p-0"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__foot purchase-summary d-none">
            <div class="kt-section kt-section--first">
                <h3 class="kt-section__title">{{ __('Product List') }}</h3>

                <div class="kt-section__body">
                    <div class="row">
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

        toggleType();

        $('#jenis').change(function() {
            toggleType();
        });

        function toggleType() {
            var type = $('#jenis').val();

            if (type == 'New') $('.new').removeClass('d-none');
            else $('.new').addClass('d-none');
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
                { title: "{{ __('Warranty') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('MAC Address') }}", defaultContent: '-', class: 'text-center' },
            ],
            drawCallback: function() {
                $('.btn-tooltip').tooltip();
            }
        });

        $('#btn-search').click(function() {
            getPurchaseData();
        });

        $('#nomor_pembelian').keypress(function(e) {
            if (e.which == 13) {
                e.preventDefault();
                getPurchaseData();
            }
        });

        function getPurchaseData() {
            var purchaseId = $('#nomor_pembelian').val();

            if (purchaseId) {
                $.ajax({
                    url: "{{ url('/api/purchase') }}/" + purchaseId,
                    statusCode: {
                        200: function(data) {
                            $('.purchase-summary').removeClass('d-none');

                            $('#purchase-details').attr('href', "{{ url('purchase') }}/" + purchaseId);
                            $('#nomor').val(data.data.id);
                            $('#total_harga').val(data.data.total_price_formatted);
                            $('#pemasok').val(data.data.supplier.name);
                            $('#metode_pembayaran').val(data.data.payment_method.name);
                            $('#status_pembayaran').val(data.data.proof_of_payment ? "{{ __('Settled') }}" : "{{ __('Not Settled') }}");
                            $('#proof-of-payment').attr('href', data.data.proof_of_payment);

                            table.clear().draw();
                            var totalQuantity = 0;
                            $.each(data.data.details, function(i, detail){
                                var quantity = detail.quantity.validated - detail.quantity.storaged;
                                var macAddress = '';
                                totalQuantity += quantity;

                                if (detail.product.mac_address) {
                                    for (var i = 0; i < quantity; i++) {
                                        macAddress += '<input type="text" class="form-control text-center" name="alamat_mac[' + detail.product.id + '][]" minlength="17" maxlength="17" required>';
                                    }
                                }

                                table.row.add([
                                    '<a href="' + detail.product.photo + '" class="kt-media kt-media--xl" target="_blank"><img src="' + detail.product.photo + '"></a>',
                                    detail.product.code,
                                    detail.product.name,
                                    numberWithCommas(quantity),
                                    detail.is_guaranteed ? '<i class="la la-clock-o btn-tooltip" title="{{ __('Warranty Expiration Date') }}"></i> ' + detail.warranty_expiration_date + '<br><i class="la la-file-text btn-tooltip" title="{{ __('Warranty Terms and Conditions') }}"></i> ' + detail.warranty_terms_and_conditions : '<i class="la la-times text-danger font-weight-bold"></i>',
                                    macAddress ? macAddress : '-'
                                ]).draw(false);
                            });

                            if (totalQuantity < 1) {
                                $('.purchase-summary').addClass('d-none');
                                @include('layouts.inc.sweetalert', ['title' => 'Error', 'text' => Lang::get('Purchase not found.')])
                            }
                        },
                        404: function() {
                            $('.purchase-summary').addClass('d-none');
                            @include('layouts.inc.sweetalert', ['title' => 'Error', 'text' => Lang::get('Purchase not found.')])
                        }
                    }
                });

                return;
            }

            $('.purchase-summary').addClass('d-none');
            @include('layouts.inc.sweetalert', ['title' => 'Error', 'text' => Lang::get('The purchase number field is required.')])
        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
@endsection