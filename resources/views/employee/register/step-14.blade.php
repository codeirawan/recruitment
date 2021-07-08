@extends('employee.register.layout')

@section('title')
    {{ __('Applicant Form') }} | {{ config('app.name') }}
@endsection

@section('style')
    <link href="{{ asset(mix('css/form/wizard.css')) }}" rel="stylesheet">
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
                            <div class="kt-wizard-v1__nav-item-title">{{ __('Questionnaire') }}</div>
                            <div class="kt-wizard-v1__nav-item-desc">{{ __('This form must be filled in completely. Incomplete filling will affect the processing of your application.')}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">
                <form class="kt-form" id="kt_form_1" action="{{ route('recruitment.register.step-14.validate', $id) }}" method="POST">
                    @csrf

                    <div class="kt-wizard-v1__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                        @include('layouts.inc.alert')

                        <div class="kt-separator kt-separator--height-xs"></div>
                        <div class="kt-form__section kt-form__section--first">

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <label>{{ __('Have you ever applied for a group/company this before? If so, as what?') }}</label> 
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="form-group col-lg-2">
                                    <div class="kt-radio-inline">
                                        <label class="kt-radio">
                                            <input type="radio">{{ __('Yes') }}
                                            <span></span>
                                        </label>
                                        <label class="kt-radio">
                                            <input type="radio">{{ __('No') }}
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <input  type="text" class="form-control" placeholder="{{ __('Explanation') }}">
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <label>{{ __('Other than here, what company are you at applying for this time? As a what?') }}</label> 
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-2">
                                    <div class="kt-radio-inline">
                                        <label class="kt-radio">
                                            <input type="radio">{{ __('Yes') }}
                                            <span></span>
                                        </label>
                                        <label class="kt-radio">
                                            <input type="radio">{{ __('No') }}
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <input type="text" class="form-control" placeholder="{{ __('Explanation') }}">
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <label>{{ __('Are you under contract with the company your current workplace? If yes, until when?') }}</label> 
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-2">
                                    <div class="kt-radio-inline">
                                        <label class="kt-radio">
                                            <input type="radio">{{ __('Yes') }}
                                            <span></span>
                                        </label>
                                        <label class="kt-radio">
                                            <input type="radio">{{ __('No') }}
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <input  type="text" class="form-control" placeholder="{{ __('Explanation') }}">
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <label>{{ __('Do you have a side job/part time? Where and as what?') }}</label> 
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-2">
                                    <div class="kt-radio-inline">
                                        <label class="kt-radio">
                                            <input type="radio">{{ __('Yes') }}
                                            <span></span>
                                        </label>
                                        <label class="kt-radio">
                                            <input type="radio">{{ __('No') }}
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <input  type="text" class="form-control" placeholder="{{ __('Explanation') }}">
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <label>{{ __('Do you mind if we ask for a reference at the company you worked for?') }}</label> 
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-2">
                                    <div class="kt-radio-inline">
                                        <label class="kt-radio">
                                            <input type="radio">{{ __('Yes') }}
                                            <span></span>
                                        </label>
                                        <label class="kt-radio">
                                            <input type="radio">{{ __('No') }}
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <input  type="text" class="form-control" placeholder="{{ __('Explanation') }}">
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <label>{{ __('Do you have friends/relatives who work in this group/company? Mention it!') }}</label> 
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-2">
                                    <div class="kt-radio-inline">
                                        <label class="kt-radio">
                                            <input type="radio">{{ __('Yes') }}
                                            <span></span>
                                        </label>
                                        <label class="kt-radio">
                                            <input type="radio">{{ __('No') }}
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <input  type="text" class="form-control" placeholder="{{ __('Explanation') }}">
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <label>{{ __('Have you ever suffered from severe/chronic illness/serious accident/operation? When and what kind?') }}</label> 
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-2">
                                    <div class="kt-radio-inline">
                                        <label class="kt-radio">
                                            <input type="radio">{{ __('Yes') }}
                                            <span></span>
                                        </label>
                                        <label class="kt-radio">
                                            <input type="radio">{{ __('No') }}
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <input  type="text" class="form-control" placeholder="{{ __('Explanation') }}">
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <label>{{ __('Have you ever had a psychological test/psychotest? When, where and for what purpose?') }}</label> 
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-2">
                                    <div class="kt-radio-inline">
                                        <label class="kt-radio">
                                            <input type="radio">{{ __('Yes') }}
                                            <span></span>
                                        </label>
                                        <label class="kt-radio">
                                            <input type="radio">{{ __('No') }}
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <input  type="text" class="form-control" placeholder="{{ __('Explanation') }}">
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <label>{{ __('Have you ever dealt with the police because of a crime?') }}</label> 
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-2">
                                    <div class="kt-radio-inline">
                                        <label class="kt-radio">
                                            <input type="radio">{{ __('Yes') }}
                                            <span></span>
                                        </label>
                                        <label class="kt-radio">
                                            <input type="radio">{{ __('No') }}
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <input  type="text" class="form-control" placeholder="{{ __('Explanation') }}">
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <label>{{ __('If accepted, are you willing to work outside the city?') }}</label> 
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-2">
                                    <div class="kt-radio-inline">
                                        <label class="kt-radio">
                                            <input type="radio">{{ __('Yes') }}
                                            <span></span>
                                        </label>
                                        <label class="kt-radio">
                                            <input type="radio">{{ __('No') }}
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <input  type="text" class="form-control" placeholder="{{ __('Explanation') }}">
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <label>{{ __('If accepted, will it be willing to be placed outside the city? State the name of the priority city/region.') }}</label> 
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-2">
                                    <div class="kt-radio-inline">
                                        <label class="kt-radio">
                                            <input type="radio">{{ __('Yes') }}
                                            <span></span>
                                        </label>
                                        <label class="kt-radio">
                                            <input type="radio">{{ __('No') }}
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <input  type="text" class="form-control" placeholder="{{ __('Explanation') }}">
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <label>{{ __('Are you willing to do work ties for a certain period (contract)?') }}</label> 
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-2">
                                    <div class="kt-radio-inline">
                                        <label class="kt-radio">
                                            <input type="radio">{{ __('Yes') }}
                                            <span></span>
                                        </label>
                                        <label class="kt-radio">
                                            <input type="radio">{{ __('No') }}
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <input  type="text" class="form-control" placeholder="{{ __('Explanation') }}">
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <label>{{ __('What type of job/position is appropriate with your ideals?') }}</label> 
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <textarea  type="text" class="form-control" placeholder="{{ __('Explanation') }}"></textarea>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <label>{{ __('What kind of work do you dislike?') }}</label> 
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <textarea  type="text" class="form-control" placeholder="{{ __('Explanation') }}"></textarea>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <label>{{ __('How much is your income a month and What facilities do you get now?') }}</label> 
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <textarea  type="text" class="form-control" placeholder="{{ __('Explanation') }}"></textarea>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <label>{{ __('If accepted, what salary and facilities do you expect?') }}</label> 
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <textarea  type="text" class="form-control" placeholder="{{ __('Explanation') }}"></textarea>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <label>{{ __('If accepted, when can you start working?') }}</label> 
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="form-group col-lg-8">
                                    <textarea  type="text" class="form-control" placeholder="{{ __('Explanation') }}"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="form-group col-lg-8">
                            <div class="kt-form__actions">
                                <a href="{{ route('recruitment.register.step-13', $id) }}" class="btn btn-outline-brand btn-md btn-tall btn-wide btn-bold btn-upper">
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
@endsection