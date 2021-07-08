@extends('layouts.app')

@section('title')
    {{ __('Storage Transaction Details') }} | {{ config('app.name') }}
@endsection

@section('style')
    <link href="{{ asset(mix('css/datatable.css')) }}" rel="stylesheet">
@endsection

@section('subheader')
    {{ __('Storage Transaction Details') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('storage-transaction.index') }}" class="kt-subheader__breadcrumbs-link">{{ __('Storage Transaction') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('storage-transaction.show', $productPost->id) }}" class="kt-subheader__breadcrumbs-link">{{ $productPost->id }}</a>
@endsection

@section('content')
<div class="kt-portlet" id="kt_page_portlet">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">{{ __('Storage Transaction Details') }}</h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="{{ route('storage-transaction.index') }}" class="btn btn-secondary">
                <i class="la la-arrow-left"></i>
                <span class="kt-hidden-mobile">{{ __('Back') }}</span>
            </a>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first">
            <div class="kt-section__body">
                @include('layouts.inc.alert')

                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="nomor_transaksi">{{ __('Transaction Number') }}</label>
                        <input id="nomor_transaksi" type="text" class="form-control" value="{{ $productPost->id }}" disabled>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="jenis_transaksi">{{ __('Transaction Type') }}</label>
                        <input id="jenis_transaksi" type="text" class="form-control" value="{{ __($productPost->type) }}" disabled>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="diposting_oleh">{{ __('Posted by') }}</label>
                        <input id="diposting_oleh" type="text" class="form-control" value="{{ $productPost->user_name }}" disabled>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="diposting_pada">{{ __('Posted at') }}</label>
                        <input id="diposting_pada" type="text" class="form-control" value="{{ $productPost->created_at->format('d-m-Y, H:i') }}" disabled>
                    </div>

                    @if ($productPost->type == 'New')
                    <div class="form-group col-sm-12">
                        <label for="nomor_pembelian">{{ __('Purchase Number') }} <a href="{{ route('purchase.show', $productPost->purchase_post_id) }}" target="_blank" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="{{ __('Purchase Details') }}" style="height: 18px; width: 18px;"><i class="la la-info-circle"></i></a></label>
                        <input id="nomor_pembelian" type="text" class="form-control" value="{{ $productPost->purchase_post_id }}" disabled>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if ($productPost->type == 'New')
    <div class="kt-portlet__foot">
        <div class="kt-section kt-section--first">
            <h3 class="kt-section__title">{{ __('Product List') }}</h3>

            <div class="kt-section__body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <table class="table table-striped- table-bordered table-hover" id="kt_table_1">
                            <tbody>
                                @foreach ($productPostDetails as $productPostDetail)
                                    @php
                                        $postDetails = $zProductPostDetails->where('product_id', $productPostDetail->product_id);
                                    @endphp
                                    <tr>
                                        <td><a href="{{ $productPostDetail->product_photo }}" class="kt-media kt-media--xl" target="_blank"><img src="{{ $productPostDetail->product_photo }}"></a></td>
                                        <td>{{ $productPostDetail->product_code }}</td>
                                        <td>{{ $productPostDetail->product_name }}</td>
                                        <td>{{ number_format($productPostDetail->quantity) }}</td>
                                        <td>
                                            @foreach ($postDetails as $postDetail)
                                                {{ $postDetail->sku }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if ($postDetails->first()->mac_address)
                                                @foreach ($postDetails as $postDetail)
                                                    {{ $postDetail->mac_address }}<br>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
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
                { title: "{{ __('Quantity') }}", defaultContent: '-', class: 'text-center' },
                { title: "SKU", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('MAC Address') }}", defaultContent: '-', class: 'text-center' }
            ],
            drawCallback: function() {
                $('.btn-tooltip').tooltip();
            }
        });
    </script>
@endsection