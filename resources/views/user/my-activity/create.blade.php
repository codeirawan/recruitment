@extends('layouts.app')

@section('title')
    {{ __('Create') }} {{ __('Activity') }} | {{ config('app.name') }}
@endsection

@section('style')
    <link href="{{ asset(mix('css/datatable.css')) }}" rel="stylesheet">
@endsection

@section('subheader')
    {{ __('Create') }} {{ __('Activity') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('my-activity.index') }}" class="kt-subheader__breadcrumbs-link">{{ __('Activity') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('my-activity.create') }}" class="kt-subheader__breadcrumbs-link">{{ __('Create') }} {{ __('Activity') }}</a>
@endsection

@section('content')
<form class="kt-form" id="kt_form_1" action="{{ route('my-activity.store') }}" method="POST">
    @csrf

    <div class="kt-portlet" id="kt_page_portlet">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">{{ __('Create') }} {{ __('Activity') }}</h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <a href="{{ route('my-activity.index') }}" class="btn btn-secondary kt-margin-r-10">
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
                            <label for="aktivitas">{{ __('Activity') }}</label>
                            <textarea id="aktivitas" class="form-control" rows="5"></textarea>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="target">Target</label>
                            <textarea id="target" class="form-control" rows="5"></textarea>
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
    <script src="{{ asset(mix('js/datatable.js')) }}"></script>
    <script src="{{ asset(mix('js/tooltip.js')) }}"></script>
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
                { title: "{{ __('Activity') }}", defaultContent: '-', class: 'text-justify', width: '40%' },
                { title: "Target", defaultContent: '-', class: 'text-justify', width: '40%' },
                { title: "{{ __('Completed') }}", defaultContent: '-', class: 'text-center', width: '10%' },
                { title: "{{ __('Action') }}", defaultContent: '-', class: 'text-center', width: '10%' },
            ],
            drawCallback: function() {
                $('.btn-tooltip').tooltip();
            }
        });

        var activityCount = 0;

        $('#btn-add').click(function() {
            var activity = $('#aktivitas').val();
            var target = $('#target').val();

            if (!activity) {
                @include('layouts.inc.sweetalert', ['title' => 'Error', 'text' => Lang::get('The activity field is required.')])
                return;
            }
            if (!target) {
                @include('layouts.inc.sweetalert', ['title' => 'Error', 'text' => Lang::get('The target field is required.')])
                return;
            }

            table.row.add([
                activity,
                target,
                '<label class="kt-checkbox kt-checkbox--bold kt-checkbox--primary"><input type="checkbox" name="aktivitas[' + activityCount + '][selesai]"><span style="top:-15px; left:23%;"></span></label>',
                '<a id="btn-delete" href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="{{ __('Delete')}}"><i class="la la-trash"></i></a>' + '<input type="hidden" name="aktivitas[' + activityCount + '][aktivitas]" value="' + activity + '">' + '<input type="hidden" name="aktivitas[' + activityCount + '][target]" value="' + target + '">'
            ]).draw(false);

            activityCount++;
        });

        $('#kt_table_1 tbody').on('click', '#btn-delete', function() {
            table.row($(this).parents('tr')).remove().draw();
        });
    </script>
@endsection