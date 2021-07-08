@extends('layouts.app')

@section('title')
    {{ __('Recruitment Details') }} | {{ config('app.name') }}
@endsection

@section('style')
    <link href="{{ asset(mix('css/datatable.css')) }}" rel="stylesheet">
@endsection

@section('subheader')
    {{ __('Recruitment Details') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('recruitment.index') }}" class="kt-subheader__breadcrumbs-link">{{ __('Recruitment') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('recruitment.show', $applicant->id) }}" class="kt-subheader__breadcrumbs-link">{{ $applicant->name }}</a>
@endsection

@section('content')
<div class="kt-portlet" id="kt_page_portlet">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">{{ __('Recruitment Details') }}</h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <a href="{{ route('recruitment.index') }}" class="btn btn-secondary">
                <i class="la la-arrow-left"></i>
                <span class="kt-hidden-mobile">{{ __('Back') }}</span>
            </a>
            @if (Laratrust::isAbleTo('update-recruitment') && $applicant->status == 'Pending')
            <a href="{{ route('recruitment.edit', $applicant->id) }}" class="btn btn-primary kt-margin-l-10">
                <i class="la la-edit"></i>
                <span class="kt-hidden-mobile">{{ __('Edit') }}</span>
            </a>
            @endif
            @if (Laratrust::isAbleTo('verify-recruitment') && $applicant->status == 'Pending')
            <a href="#" data-id="{{ $applicant->id }}" data-toggle="modal" data-target="#modal-verify" data-key="{{ $applicant->name }}" class="btn btn-success kt-margin-l-10">
                <i class="la la-check"></i>
                <span class="kt-hidden-mobile">{{ __('Verify') }}</span>
            </a>
            @endif
            @if (Laratrust::isAbleTo('validate-recruitment') && $applicant->status == 'Scheduled')
            <a href="#" data-id="{{ $applicant->id }}" data-toggle="modal" data-target="#modal-validate" data-key="{{ $applicant->name }}" class="btn btn-primary kt-margin-l-10">
                <i class="fa fa-user-check"></i>
                <span class="kt-hidden-mobile">{{ __('Validate') }}</span>
            </a>
            @endif
            @if (Laratrust::isAbleTo('create-schedule-recruitment') && ($applicant->status == 'Qualified' || $applicant->status == 'Scheduled'))
            <a href="#" data-href="{{ route('recruitment.schedule', $applicant->id) }}" data-toggle="modal" data-target="#modal-schedule" class="btn btn-info kt-margin-l-10">
                <i class="la la-calendar"></i>
                <span class="kt-hidden-mobile">{{ __('Create Interview Schedule') }}</span>
            </a>
            @endif
            @if (Laratrust::isAbleTo('cancel-recruitment') && ($applicant->status == 'Qualified' || $applicant->status == 'Scheduled' || $applicant->status == 'Passed'))
            <a href="#" data-href="{{ route('recruitment.cancel', $applicant->id) }}" data-toggle="modal" data-target="#modal-cancel" class="btn btn-warning kt-margin-l-10">
                <i class="la la-ban"></i>
                <span class="kt-hidden-mobile">{{ __('Cancel') }}</span>
            </a>
            @endif
            @if (Laratrust::isAbleTo('delete-recruitment') && $applicant->status == 'Pending')
            <a href="#" data-href="{{ route('recruitment.destroy', $applicant->id) }}" class="btn btn-danger kt-margin-l-10" title="{{ __('Delete') }}" data-toggle="modal" data-target="#modal-delete" data-key="{{ $applicant->name }}">
                <i class="la la-trash"></i>
                <span class="kt-hidden-mobile">{{ __('Delete') }}</span>
            </a>
            @endif
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="kt-section kt-section--first">
            <div class="kt-section__body">
                @include('layouts.inc.alert')

                <div class="row">
                    <div class="form-group col-sm-12">
                        <label>{{ __('Name') }}</label>
                        <input type="text" class="form-control" value="{{ $applicant->name }}" disabled>
                    </div>

                    <div class="form-group col-sm-6">
                        <label>{{ __('Email') }}</label>
                        <input type="text" class="form-control" value="{{ $applicant->email }}" disabled>
                    </div>

                    <div class="form-group col-sm-6">
                        <label>{{ __('Phone Number') }}</label>
                        <input type="text" class="form-control" value="{{ $applicant->phone_number ?? '-' }}" disabled>
                    </div>

                    <div class="form-group col-sm-6">
                        <label>{{ __('Resume Source') }}</label>
                        <div class="input-group">
                            <input id="sumber_cv" type="text" class="form-control" value="{{ $applicant->resume_source }}" disabled>
                            <div class="input-group-append">
                                <a href="{{ $applicant->resume }}" class="btn btn-primary btn-tooltip" target="_blank" title="{{ __('View') . ' ' . __('Resume') }}"><i class="fa fa-eye kt-font-light p-0"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-sm-6">
                        <label>{{ __('Position') }}</label>
                        <input type="text" class="form-control" disabled value="{{ $applicant->position }}">
                    </div>

                    <div class="form-group col-sm-6">
                        <label>{{ __('City') }}</label>
                        <input type="text" class="form-control" disabled value="{{ $applicant->city }}">
                    </div>

                    <div class="form-group col-sm-6">
                        <label>{{ __('Interview Schedule') }}</label>
                        <input type="text" class="form-control" disabled value="{{ $applicant->interview_at ? $applicant->interview_at->format('d-m-Y, H:i') : '-' }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="kt-portlet__foot">
        <div class="kt-section kt-section--first">
            <h3 class="kt-section__title">{{ __('Recruitment Status') }}</h3>

            <div class="kt-section__body">
                <div class="kt-list kt-list--badge">
                    @foreach ($applicantStatus as $sApplicant)
                        @php
                            $color = $sApplicant->status == 'Pending' ? 'metal'
                                        : ($sApplicant->status == 'Qualified' ? 'success'
                                            : ($sApplicant->status == 'Not Qualified' ? 'danger'
                                                : ($sApplicant->status == 'Canceled' ? 'warning'
                                                    : ($sApplicant->status == 'Scheduled' ? 'info'
                                                        : ($sApplicant->status == 'Passed' ? 'primary'
                                                            : 'secondary')))));
                            $icon = $sApplicant->status == 'Pending' ? 'hourglass-half'
                                        : ($sApplicant->status == 'Qualified' ? 'check'
                                            : ($sApplicant->status == 'Not Qualified' ? 'times'
                                                : ($sApplicant->status == 'Canceled' ? 'ban'
                                                    : ($sApplicant->status == 'Scheduled' ? 'calendar-alt'
                                                        : ($sApplicant->status == 'Passed' ? 'user-check'
                                                            : 'user-times')))));
                            $note = $sApplicant->status == 'Not Qualified' || $sApplicant->status == 'Not Passed' || $sApplicant->status == 'Canceled'
                                        ? Lang::get('Reason') . ': ' . $sApplicant->note
                                        : Lang::get('Note') . ': ' . $sApplicant->note;
                        @endphp

                        <div class="kt-list__item">
                            <span class="kt-list__badge kt-list__badge--{{ $color }}"></span>
                            <span class="kt-list__icon"><i class="fa fa-{{ $icon }} kt-font-{{ $color }}" style="font-size: 1.6rem;"></i></span>
                            <span class="kt-list__text">{{ __($sApplicant->status) }} {{ __('by') }} <a href="{{ route('user.show', $sApplicant->user_id) }}" class="kt-link">{{ $sApplicant->user_name }}</a>. {{ $note }}</span>
                            <span class="kt-list__time w-25">{{ $sApplicant->at->diffForHumans(now()) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @if ($applicant->status == 'Passed' || $applicant->status == 'Not Passed')
        <div class="kt-portlet__foot">
            <div class="kt-section kt-section--first">
                <h3 class="kt-section__title">{{ __('Recruitment File') }}</h3>

                <div class="kt-section__body">
                    <a href="#" class="btn btn-primary mb-4" data-toggle="modal" data-target="#modal-new-file">
                        <i class="fa fa-plus"></i>  {{ __('New File') }}
                    </a>

                    <table class="table table-striped- table-bordered table-hover" id="kt_table_1"></table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('script')
    @include('employee.recruitment.inc.modal.verify', ['object' => 'recruitment'])
    @include('layouts.inc.modal.delete', ['object' => 'recruitment'])
    @include('employee.recruitment.inc.modal.cancel')
    @include('employee.recruitment.inc.modal.schedule')
    @if ($applicant->status == 'Scheduled')
        @include('employee.recruitment.inc.modal.validate', ['object' => 'recruitment'])
    @elseif ($applicant->status == 'Passed' || $applicant->status == 'Not Passed')
        @include('employee.recruitment.inc.modal.new-file')
        @include('employee.recruitment.inc.modal.delete-file')
    @endif

    <script src="{{ asset(mix('js/datatable.js')) }}"></script>
    <script src="{{ asset(mix('js/tooltip.js')) }}"></script>
    <script src="{{ asset(mix('js/form/validation.js')) }}"></script>
    <script type="text/javascript">
        $('#kt_table_1').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
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
            ajax: {
                method: 'POST',
                url: "{{ url('/recruitment') . '/' . $applicant->id }}/file/data",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            },
            columns: [
                { title: "{{ __('File Type') }}", data: 'file_type', name: 'file_type', defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Uploaded by') }}", data: 'by', name: 'by', defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Uploaded at') }}", data: 'created_at', name: 'created_at', defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Action') }}", data: 'action', name: 'action', defaultContent: '-', class: 'text-center', searchable: false, orderable: false }
            ],
            drawCallback: function() {
                $('.btn-tooltip').tooltip();
            }
        });
    </script>
@endsection