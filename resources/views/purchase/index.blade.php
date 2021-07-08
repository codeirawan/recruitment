@extends('layouts.app')

@section('title')
    {{ __('Purchase') }} | {{ config('app.name') }}
@endsection

@section('style')
    <link href="{{ asset(mix('css/datatable.css')) }}" rel="stylesheet">
@endsection

@section('subheader')
    {{ __('Purchase') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ ('purchase.index') }}" class="kt-subheader__breadcrumbs-link">{{ __('Purchase') }}</a>
@endsection

@section('content')
<div class="kt-portlet">
    <div class="kt-portlet__body">
        <div class="kt-portlet__content">
            @include('layouts.inc.alert')

            @if (Laratrust::isAbleTo('create-purchase'))
                <a href="{{ ('purchase.create') }}" class="btn btn-primary mb-4">
                    <i class="fa fa-plus"></i> {{ __('New Purchase') }}
                </a>
            @endif

            <table class="table table-striped- table-bordered table-hover" id="kt_table_1"></table>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ asset(mix('js/datatable.js')) }}"></script>
    <script src="{{ asset(mix('js/tooltip.js')) }}"></script>
    <script type="text/javascript">
        $('#kt_table_1').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
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
            ajax: {
                method: 'POST',
                url: '{{ ('purchase.data') }}',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            },
            columns: [
                { title: "{{ __('Submitted at') }}", data: 'created_at', name: 'created_at', defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Number') }}", data: 'id', name: 'id', defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Total Price') }}", data: 'total_price', name: 'total_price', defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Supplier') }}", data: 'supplier', name: 'supplier', defaultContent: '-', class: 'text-center', searchable: false },
                { title: "{{ __('Payment Method') }}", data: 'payment_method', name: 'payment_method', defaultContent: '-', class: 'text-center', searchable: false },
                { title: "{{ __('Settled') }}", data: 'proof_of_payment', name: 'proof_of_payment', defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Status') }}", data: 'status', name: 'status', defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Action') }}", data: 'action', name: 'action', defaultContent: '-', class: 'text-center', searchable: false, orderable: false }
            ],
            drawCallback: function() {
                $('.btn-tooltip').tooltip();
            },
            order: [[0, 'desc']]
        });
    </script>
@endsection