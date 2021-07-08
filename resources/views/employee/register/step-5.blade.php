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
                            <div class="kt-wizard-v1__nav-item-title">{{ __('Foreign Language Skills') }}</div>
                            <div class="kt-wizard-v1__nav-item-desc">{{ __('This form must be filled in completely. Incomplete filling will affect the processing of your application.')}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">
                <form class="kt-form" id="kt_form_1" action="{{ route('recruitment.register.step-5.validate', $id) }}" method="POST">
                    @csrf

                    <div class="kt-wizard-v1__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                        @include('layouts.inc.alert')
                                            
                        <div class="kt-separator kt-separator--height-xs"></div>
                        <div class="kt-form__section kt-form__section--first">

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-2">
                                    <label for="bahasa">{{ __('Language') }}</label>
                                    <input type="text" class="form-control" id="bahasa" >
                                </div>

                                <div class="form-group col-lg-1">
                                    <label for="berbicara">{{ __('Speaking') }}</label>
                                    <select class="form-control" id="berbicara">
                                        <option value="Good">{{ __('Good') }}</option>
                                        <option value="Enough">{{ __('Enough') }}</option>
                                        <option value="Less">{{ __('Less') }}</option>
                                    </select>
                                </div>

                                <div class="form-group col-lg-1">
                                    <label for="mendengar">{{ __('Listening') }}</label>
                                    <select class="form-control" id="mendengar">
                                        <option value="Good">{{ __('Good') }}</option>
                                        <option value="Enough">{{ __('Enough') }}</option>
                                        <option value="Less">{{ __('Less') }}</option>
                                    </select>
                                </div>

                                <div class="form-group col-lg-1">
                                    <label for="membaca">{{ __('Reading') }}</label>
                                    <select class="form-control" id="membaca">
                                        <option value="Good">{{ __('Good') }}</option>
                                        <option value="Enough">{{ __('Enough') }}</option>
                                        <option value="Less">{{ __('Less') }}</option>
                                    </select>
                                </div>

                                <div class="form-group col-lg-1">
                                    <label for="menulis">{{ __('Writing') }}</label>
                                    <select class="form-control" id="menulis">
                                        <option value="Good">{{ __('Good') }}</option>
                                        <option value="Enough">{{ __('Enough') }}</option>
                                        <option value="Less">{{ __('Less') }}</option>
                                    </select>
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="pemakaian">{{ __('Usage') }}</label>
                                    <select class="form-control" id="pemakaian">
                                        <option value="Active">{{ __('Active') }}</option>
                                        <option value="Passive">{{ __('Passive') }}</option>
                                    </select>
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
                                <a href="{{ route('recruitment.register.step-4', $id) }}" class="btn btn-outline-brand btn-md btn-tall btn-wide btn-bold btn-upper">
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
                { title: "{{ __('Language') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Speaking') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Listening') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Reading') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Writing') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Usage') }}", defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Action') }}", defaultContent: '-', class: 'text-center' },
            ],
            drawCallback: function() {
                $('.btn-tooltip').tooltip();
            }
        });

        var languageCount = 0;
    
        $('#btn-add').click(function() {
            var language = $('#bahasa').val();
            var speaking = $('#berbicara').val();
            var listening = $('#mendengar').val();
            var reading = $('#membaca').val();
            var writing = $('#menulis').val();
            var usage = $('#pemakaian').val();

            if (!language) {
                @include('layouts.inc.sweetalert', ['title' => 'Error', 'text' => Lang::get('The language field is required.')])
                return;
            }

            table.row.add([
                language,
                speaking,
                listening,
                reading,
                writing,
                usage,
                '<a id="btn-delete" href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="{{ __('Delete')}}"><i class="la la-trash"></i></a>' + 
                '<input type="hidden" name="bahasa[' + languageCount + '][bahasa]" value="' + language + '">' + 
                '<input type="hidden" name="bahasa[' + languageCount + '][berbicara]" value="' + speaking + '">' + 
                '<input type="hidden" name="bahasa[' + languageCount + '][mendengar]" value="' + listening + '">' + 
                '<input type="hidden" name="bahasa[' + languageCount + '][membaca]" value="' + reading + '">' + 
                '<input type="hidden" name="bahasa[' + languageCount + '][menulis]" value="' + writing + '">' + 
                '<input type="hidden" name="bahasa[' + languageCount + '][pemakaian]" value="' + usage + '">'
            ]).draw(false);

            languageCount++;
        });

        $('#kt_table_1 tbody').on('click', '#btn-delete', function() {
            table.row($(this).parents('tr')).remove().draw();
        });
    </script>
@endsection