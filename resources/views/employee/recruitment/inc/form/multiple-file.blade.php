<div class="row">
    <div class="form-group col-sm-5">
        <input type="file" class="form-control" name="file[]" accept="application/pdf,image/*" required>
    </div>
    <div class="form-group col-sm-5">
        <select name="jenis_file[]" class="form-control" required>
            @foreach ($fileTypes as $fileType)
                <option value="{{ $fileType->id }}">{{ $fileType->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-sm-2">
        <button type="button" class="btn btn-primary btn-block btn-tooltip" id="btn-add" title="{{ __('Add') }} File">
            <i class="fa fa-plus p-0"></i>
        </button>
    </div>
</div>

<div class="files d-none" id="files">
    <div class="row">
        <div class="form-group col-sm-5">
            <input type="file" class="form-control input-file" accept="application/pdf,image/*">
        </div>
        <div class="form-group col-sm-5">
            <select class="form-control input-file-type">
                @foreach ($fileTypes as $fileType)
                    <option value="{{ $fileType->id }}">{{ $fileType->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-sm-2">
            <button type="button" class="btn btn-danger btn-block btn-tooltip btn-remove" title="{{ __('Remove') }} File">
                <i class="fa fa-trash p-0"></i>
            </button>
        </div>
    </div>
</div>

<script>
    $('#btn-add').click(function() {
        var template = $('#files');
        var clone = template.clone().removeAttr('id').removeClass('d-none');
        $('.input-file', clone).attr('name', 'file[]');
        $('.input-file-type', clone).attr('name', 'jenis_file[]');
        $('.btn-remove', clone).click(function() {
            $(this).closest('div.files').remove();
        });
        template.before(clone);
    });
</script>