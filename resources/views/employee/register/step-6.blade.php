@extends('employee.register.layout')

@section('title')
    {{ __('Applicant Form') }} | {{ config('app.name') }}
@endsection

@section('style')
    <link href="{{ asset(mix('css/form/wizard.css')) }}" rel="stylesheet">
    <link href="{{ asset(mix('css/datatable.css')) }}" rel="stylesheet">
@endsection

@section('subheader')
    {{ __('Applicant Form') }}
@endsection

@section('content')
<div class="kt-portlet">
    <div class="kt-portlet__body kt-portlet__body--fit">
        <div class="kt-grid kt-grid--desktop-xl kt-grid--ver-desktop-xl  kt-wizard-v1" id="kt_wizard_v1" data-ktwizard-state="step-first">
            <div class="kt-grid__item kt-wizard-v1__aside">
                <div class="kt-wizard-v1__nav">
                    @include('employee.register.inc.wizard')

                    <div class="kt-wizard-v1__nav-details">
                        <div class="kt-wizard-v1__nav-item-wrapper" data-ktwizard-type="step-info" data-ktwizard-state="current">
                            <div class="kt-wizard-v1__nav-item-title">{{ __('Social Activities') }}</div>
                            <div class="kt-wizard-v1__nav-item-desc">{{ __('This form must be filled in completely. Incomplete filling will affect the processing of your application.')}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">
                <form class="kt-form" id="kt_form_1" action="{{ route('recruitment.register.step-6.validate', $id) }}" method="POST">
                    @csrf

                    <div class="kt-wizard-v1__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                        @include('layouts.inc.alert')
                                            
                        <div class="kt-separator kt-separator--height-xs"></div>
                        <div class="kt-form__section kt-form__section--first">

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-2">
                                    <label for="tahun">{{ __('Year') }}</label>
                                    <input type="numeric" class="form-control" id="tahun">
                                </div>

                                <div class="form-group col-lg-6">
                                    <label for="nama_organisasi">{{ __('Organization Name') }}</label>
                                    <input type="text" class="form-control" id="nama_organisasi">
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-4">
                                    <label for="jenis_kegiatan">{{ __('Activity Type') }}</label>
                                    <input type="text" class="form-control" id="jenis_kegiatan" >
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="jabatan">{{ __('Position') }}</label>
                                    <input type="text" class="form-control" id="jabatan">
                                </div>
                            </div>
                            
                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <button type="button" class="btn btn-primary  btn-block btn-input" id="btn-add">
                                        <i class="la la-plus"></i>
                                        <span class="kt-hidden-mobile">{{ __('Add') }}</span>
                                    </button>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <table class="table table-striped- table-bordered table-hover" id="kt_table_1"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group col-lg-8">
                            <div class="kt-form__actions">
                                <a href="{{ route('recruitment.register.step-5', $id) }}" class="btn btn-outline-brand btn-md btn-tall btn-wide btn-bold btn-upper">
                                    {{ __('Back') }}
                                </a>
        
                                <button type="submit" class="btn btn-brand btn-md btn-tall btn-wide btn-bold btn-upper" data-ktwizard-type="action-next">
                                    {{ __('Next Step') }}
                                </button>
                            </div>
                        </div>
                    </div>                   
                </form>
            </div>
        </div>
    </div>
</div>
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
                { title: "{{ __('Year') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Organization Name') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Activity Type') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Position') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Action') }}", defaultContent: '-', class: 'text-center' },
            ],
            drawCallback: function() {
                $('.btn-tooltip').tooltip();
            }
        });

        var yearCount = 0;
    
        $('#btn-add').click(function() {
            var year = $('#tahun').val();
            var organization = $('#nama_organisasi').val();
            var activity = $('#jenis_kegiatan').val();
            var position = $('#jabatan').val();
            
            if (!organization) {
                @include('layouts.inc.sweetalert', ['title' => 'Error', 'text' => Lang::get('The organization name field is required.')])
                return;
            }

            table.row.add([
                year,
                organization,
                activity,
                position,
                '<a id="btn-delete" href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="{{ __('Delete')}}"><i class="la la-trash"></i></a>' + 
                '<input type="hidden" name="organisasi[' + yearCount + '][tahun]" value="' + year + '">' + 
                '<input type="hidden" name="organisasi[' + yearCount + '][nama_organisasi]" value="' + organization + '">' + 
                '<input type="hidden" name="organisasi[' + yearCount + '][jenis_kegiatan]" value="' + activity + '">' + 
                '<input type="hidden" name="organisasi[' + yearCount + '][jabatan]" value="' + position + '">'
            ]).draw(false);

            yearCount++;
        });

        $('#kt_table_1 tbody').on('click', '#btn-delete', function() {
            table.row($(this).parents('tr')).remove().draw();
        });
    </script>
@endsection