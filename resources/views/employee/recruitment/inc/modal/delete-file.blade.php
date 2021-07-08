<div class="modal fade" id="modal-delete-file" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" role="form" id="modal-delete-file-action">
                @method('DELETE')
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Delete Confirmation') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="modal-delete-file-message"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#modal-delete-file').on('show.bs.modal', function(event){
        var key = $(event.relatedTarget).data('key');

        $('#modal-delete-file-action').attr('action', $(event.relatedTarget).data('href'));
        $('#modal-delete-file-message').text("{{ __('Are you sure you want to delete this file') }} (" + key + ") ?");
    });
</script>