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
                            <div class="kt-wizard-v1__nav-item-title">{{ __('Courses / training that have been conducted') }}</div>
                            <div class="kt-wizard-v1__nav-item-desc">{{ __('This form must be filled in completely. Incomplete filling will affect the processing of your application.')}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">
                <form class="kt-form" id="kt_form_1" action="{{ route('recruitment.register.step-4.validate', $id) }}" method="POST">
                    @csrf

                    <div class="kt-wizard-v1__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                        @include('layouts.inc.alert')
                                            
                        <div class="kt-separator kt-separator--height-xs"></div>
                        <div class="kt-form__section kt-form__section--first">

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-2">
                                    <label for="bidang">{{ __('Field / Type') }}</label>
                                    <input type="text" class="form-control"  id="bidang">
                                </div>

                                <div class="form-group col-lg-3">
                                    <label for="lembaga">{{ __('Institution') }}</label>
                                    <input type="text" class="form-control" id="lembaga">
                                </div>

                                <div class="form-group col-lg-3">
                                    <label for="kota">{{ __('City') }} / {{ __('Regency') }}</label>
                                    <select class="form-control kt_selectpicker" id="kota" data-live-search="true" title="{{ __('Choose') }} {{ __('City') }} / {{ __('Regency') }}">
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->name }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-2">
                                    <label for="lama_kursus">{{ __('Course Duration') }}</label>
                                    <input type="text" class="form-control" id="lama_kursus">
                                </div>

                                <div class="form-group col-lg-2">
                                    <label for="tahun">{{ __('Year') }}</label>
                                    <input type="text" class="form-control" id="tahun">
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="dibiyai_oleh">{{ __('Financed by') }}</label>
                                    <input type="text" class="form-control" id="dibiyai_oleh">
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
                                <a href="{{ route('recruitment.register.step-3', $id) }}" class="btn btn-outline-brand btn-md btn-tall btn-wide btn-bold btn-upper">
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
    <script src="{{ asset(mix('js/form/validation.js')) }}"></script>
    <script src="{{ asset(mix('js/datatable.js')) }}"></script>
    <script src="{{ asset(mix('js/tooltip.js')) }}"></script>
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
                { title: "{{ __('Field / Type') }}", data: 'bidang', name: 'bidang', defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Institution') }}", data: 'lembaga', name: 'lembaga', defaultContent: '-', class: 'text-center' },
                { title: "{{ __('City') }}", data: 'kota', name: 'kota', defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Course Duration') }}", data: 'lama_kursus', name: 'lama_kursus', defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Year') }}", data: 'tahun', name: 'tahun', defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Financed by') }}", data: 'dibiyai_oleh', name: 'dibiyai_oleh', defaultContent: '-', class: 'text-center' },
                { title: "{{ __('Action') }}", defaultContent: '-', class: 'text-center' },
            ],
            drawCallback: function() {
                $('.btn-tooltip').tooltip();
            }
        });

        var coursesCount = parseInt("{{ $data ? count($data['kursus']) : 0 }}");
    
        $('#btn-add').click(function() {
            var field = $('#bidang').val();
            var institution = $('#lembaga').val();
            var city = $('#kota').val();
            var duration = $('#lama_kursus').val();
            var year = $('#tahun').val();
            var financed = $('#dibiyai_oleh').val();

            if (!institution) {
                @include('layouts.inc.sweetalert', ['title' => 'Error', 'text' => Lang::get('The institution field is required.')])
                return;
            }

            table.row.add([
                field,
                institution,
                city,
                duration,
                year,
                financed,
                '<a id="btn-delete" href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="{{ __('Delete')}}"><i class="la la-trash"></i></a>' + 
                '<input type="hidden" name="kursus[' + coursesCount + '][bidang]" value="' + field + '">' + 
                '<input type="hidden" name="kursus[' + coursesCount + '][lembaga]" value="' + institution + '">' + 
                '<input type="hidden" name="kursus[' + coursesCount + '][kota]" value="' + city + '">' + 
                '<input type="hidden" name="kursus[' + coursesCount + '][lama_kursus]" value="' + duration + '">' + 
                '<input type="hidden" name="kursus[' + coursesCount + '][tahun]" value="' + year + '">' + 
                '<input type="hidden" name="kursus[' + coursesCount + '][dibiyai_oleh]" value="' + financed + '">'
            ]).draw(false);

            coursesCount++;
        });

        $('#kt_table_1 tbody').on('click', '#btn-delete', function() {
            table.row($(this).parents('tr')).remove().draw();
        });
    </script>
@endsection