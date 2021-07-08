<div class="modal fade" id="modal-schedule" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="kt_form_1" method="POST" role="form" class="modal-schedule-action">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Create Interview Schedule') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="tanggal">{{ __('Date') }}</label>
                            <input type="text" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" id="tanggal" placeholder="{{ __('Select') }} {{ __('Date') }}" readonly value="{{ old('tanggal') }}" required>

                            @error('tanggal')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="waktu">{{ __('Time') }}</label>
                            <input type="text" class="form-control @error('waktu') is-invalid @enderror" name="waktu" id="waktu" placeholder="{{ __('Select') }} {{ __('Time') }}" readonly value="{{ old('waktu') }}" required>

                            @error('waktu')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="catatan">{{ __('Note') }}</label>
                            <textarea id="catatan" name="catatan" class="form-control">{{ old('catatan') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#tanggal').datepicker({
        autoclose: true,
        clearBtn: true,
        disableTouchKeyboard: true,
        format: "dd-mm-yyyy",
        language: "{{ config('app.locale') }}",
        startDate: "0d",
        templates: {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        },
        todayBtn: "linked",
        todayHighlight: true
    });

    $('#waktu').timepicker({
        disableFocus: true,
        disableMousewheel: true,
        minuteStep: 1,
        showMeridian: false
    });

    $('#modal-schedule').on('show.bs.modal', function(event){
        $('.modal-schedule-action').attr('action', $(event.relatedTarget).data('href'));
    });
</script>
