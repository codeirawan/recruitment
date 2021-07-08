@extends('layouts.app')

@section('title')
    {{ __('Supplier Details') }} | {{ config('app.name') }}
@endsection

@section('style')
    <link href="{{ asset(mix('css/datatable.css')) }}" rel="stylesheet">
@endsection

@section('subheader')
    {{ __('Supplier Details') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('supplier.index') }}" class="kt-subheader__breadcrumbs-link">{{ __('Supplier') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('supplier.show', $supplier->id) }}" class="kt-subheader__breadcrumbs-link">{{ $supplier->name }}</a>
@endsection

@section('content')
<div class="kt-portlet" id="kt_page_portlet">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">{{ __('Supplier Details') }}</h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="{{ route('supplier.index') }}" class="btn btn-secondary">
                <i class="la la-arrow-left"></i>
                <span class="kt-hidden-mobile">{{ __('Back') }}</span>
            </a>
            @if (Laratrust::can('update-supplier'))
            <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-primary kt-margin-l-10">
                <i class="la la-edit"></i>
                <span class="kt-hidden-mobile">{{ __('Edit') }}</span>
            </a>
            @endif
            @if (Laratrust::can('delete-supplier'))
            <a href="#" data-href="{{ route('supplier.destroy', $supplier->id) }}" class="btn btn-danger kt-margin-l-10" title="{{ __('Delete') }}" data-toggle="modal" data-target="#modal-delete" data-key="{{ $supplier->name }}">
                <i class="la la-trash"></i>
                <span class="kt-hidden-mobile">{{ __('Delete') }}</span>
            </a>
            @endif
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first">
            <div class="kt-section__body">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="nama">{{ __('Name') }}</label>
                        <input id="nama" type="text" class="form-control" value="{{ $supplier->name }}" disabled>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="jenis">{{ __('Type') }}</label>
                        <input id="jenis" type="text" class="form-control" value="{{ __($supplier->type) }}" disabled>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="nomor_telepon">{{ __('Telephone Number') }}</label>
                        <input id="nomor_telepon" type="text" class="form-control" value="{{ $supplier->telephone }}" disabled>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="npwp">NPWP</label>
                        <input id="npwp" type="text" class="form-control" value="{{ $supplier->npwp }}" disabled>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="alamat">{{ __('Address') }}</label>
                        <textarea id="alamat" class="form-control" disabled>{{ $supplier->address }}</textarea>
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
                        <table class="table table-striped- table-bordered table-hover" id="kt_table_1"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    @include('layouts.inc.modal.delete', ['object' => 'supplier'])

    <script src="{{ asset(mix('js/datatable.js')) }}"></script>
    <script type="text/javascript">
        var table = $('#kt_table_1').DataTable({
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
                url: "{{ url('/supplier') . '/' . $supplier->id }}/product/data",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            },
            columns: [
                { title: "{{ __('Photo') }}", data: 'photo', name: 'photo', defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Code') }}", data: 'code', name: 'code', defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Name') }}", data: 'name', name: 'name', defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Category') }}", data: 'category', name: 'category', defaultContent: '-', class: 'text-center', orderable: false, searchable: false }
            ],
            order: [[1, 'asc']]
        });
    </script>
@endsection