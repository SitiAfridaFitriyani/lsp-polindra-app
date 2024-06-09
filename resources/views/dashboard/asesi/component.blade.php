<script>
    document.addEventListener('DOMContentLoaded', function() {
        getData()
    });
    function modalFormCreate(elemen)
    {
        const targetModal = elemen.getAttribute('data-target');
        const form = $('.needs-validation');

        $('#container-file-photo-show').addClass('d-none');
        $('#editForm-container').addClass('d-none');
        $('#editForm-status').addClass('d-none');
        $(`${targetModal}`).modal('show');
        $('#asesi-modal-title').text('Tambah Asesi');
        $('#btn-form').text('Simpan');
        form.attr('action','{{ route("asesi.store") }}');
        form.attr('data-method','POST');
    }

    $('#modal-asesi').on('hidden.bs.modal', function () {
        $('#form-asesi').trigger('reset');
        $('#_method').remove();
    });
</script>
