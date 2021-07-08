@extends('layouts.app')

@section('title')
    {{ __('Purchase Validation Details') }} | {{ config('app.name') }}
@endsection

@section('style')
    <link href="{{ asset(mix('css/datatable.css')) }}" rel="stylesheet">
@endsection

@section('subheader')
    {{ __('Purchase Validation Details') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ ('purchase.index') }}" class="kt-subheader__breadcrumbs-link">{{ __('Purchase') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ ('purchase.show', $purchaseValidate->id) }}" class="kt-subheader__breadcrumbs-link">{{ $purchaseValidate->id }}</a>
@endsection

@section('content')
<div class="kt-portlet" id="kt_page_portlet">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">{{ __('Purchase Validation Details') }}</h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="{{ ('purchase.show', $purchaseValidate->id) }}" class="btn btn-secondary">
                <i class="la la-arrow-left"></i>
                <span class="kt-hidden-mobile">{{ __('Back') }}</span>
            </a>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first">
            <div class="kt-section__body">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="nomor">{{ __('Number') }}</label>
                        <input id="nomor" type="text" class="form-control" value="{{ $purchaseValidate->id }}" disabled>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="total_harga">{{ __('Total Price') }}</label>
                        <input id="total_harga" type="text" class="form-control" value="Rp{{ number_format($purchaseValidate->total_price, 2) }}" disabled>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="pemasok">{{ __('Supplier') }}</label>
                        <input id="pemasok" type="text" class="form-control" value="{{ $purchaseValidate->supplier }}" disabled>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="metode_pembayaran">{{ __('Payment Method') }}</label>
                        <input id="metode_pembayaran" type="text" class="form-control" value="{{ $purchaseValidate->payment_method }}" disabled>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="status_pembayaran">{{ __('Payment Status') }}</label>
                        <div class="input-group">
                            <input id="status_pembayaran" type="text" class="form-control" value="{{ $purchaseValidate->proof_of_payment ? __('Settled') : __('Not Settled') }}" disabled>
                            <div class="input-group-append">
                                <a href="{{ $purchaseValidate->proof_of_payment }}" class="btn btn-primary btn-tooltip" target="_blank" title="{{ __('View') . ' ' . __('Proof of Payment') }}">
                                    <i class="fa fa-eye kt-font-light p-0"></i>
                                </a>
                            </div>
                        </div>
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
                    <div class="form-group col-sm-12">
                        <table class="table table-striped- table-bordered table-hover" id="kt_table_1">
                            <tbody>
                                @foreach ($purchaseValidateDetails as $purchaseValidateDetail)
                                    <tr>
                                        <td><a href="{{ $purchaseValidateDetail->product_photo }}" class="kt-media kt-media--xl" target="_blank"><img src="{{ $purchaseValidateDetail->product_photo }}"></a></td>
                                        <td>{{ $purchaseValidateDetail->product_code }}</td>
                                        <td>{{ $purchaseValidateDetail->product_name }}</td>
                                        <td>{{ number_format($purchaseValidateDetail->lack) }}</td>
                                        <td>{{ number_format($purchaseValidateDetail->defective) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ asset(mix('js/datatable.js')) }}"></script>
    <script type="text/javascript">
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
                { title: "{{ __('Lack') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Defective') }}", defaultContent: '-', class: 'text-center' }
            ],
            drawCallback: function() {
                $('.btn-tooltip').tooltip();
            }
        });
    </script>
@endsection