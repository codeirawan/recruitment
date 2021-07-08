<div class="modal fade" id="modal-validate" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form method="POST" role="form" id="modal-validate-action" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Validate Confirmation') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="modal-validate-message"></p>

                    @include('employee.recruitment.inc.form.multiple-file')

                    <textarea id="catatan" name="catatan" class="form-control" placeholder="{{ __('Note') }}">{{ old('catatan') }}</textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="btn-gagal">{{ __('No') }}</button>
                    <button type="button" class="btn btn-success" id="btn-lolos">{{ __('Yes') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var id = 0;

    $('#modal-validate').on('show.bs.modal', function(event){
        var key = $(event.relatedTarget).data('key');
        id = $(event.relatedTarget).data('id');

        $('#modal-validate-message').text("{{ __('Does this ' . $object) }} (" + key + ") {{ __('pass') }} ?");
    });

    $('#btn-gagal').click(function() {
        $('#modal-validate-action').attr('action', "{{ url('recruitment') }}/" + id + "/validate/0").submit();
    });

    $('#btn-lolos').click(function() {
        $('#modal-validate-action').attr('action', "{{ url('recruitment') }}/" + id + "/validate/1").submit();
    });
</script>