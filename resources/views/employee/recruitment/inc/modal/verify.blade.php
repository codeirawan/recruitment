<div class="modal fade" id="modal-verify" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" role="form" id="modal-verify-action">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Verify Confirmation') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="modal-verify-message"></p>
                    <textarea id="catatan" name="catatan" class="form-control" placeholder="{{ __('Note') }}">{{ old('catatan') }}</textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="btn-no">{{ __('No') }}</button>
                    <button type="button" class="btn btn-success" id="btn-yes">{{ __('Yes') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var id = 0;

    $('#modal-verify').on('show.bs.modal', function(event){
        var key = $(event.relatedTarget).data('key');
        id = $(event.relatedTarget).data('id');

        $('#modal-verify-message').text("{{ __('Does this ' . $object) }} (" + key + ") {{ __('qualify') }} ?");
    });

    $('#btn-no').click(function() {
        $('#modal-verify-action').attr('action', "{{ url('recruitment') }}/" + id + "/verify/0").submit();
    });

    $('#btn-yes').click(function() {
        $('#modal-verify-action').attr('action', "{{ url('recruitment') }}/" + id + "/verify/1").submit();
    });
</script>