<script>
    document.addEventListener('DOMContentLoaded', function() {
        getData()
    });
    function modalFormCreate(elemen)
    {
        const targetModal = elemen.getAttribute('data-target');
        $(`${targetModal}`).modal('show');
        $('#jurusan-modal-title').text('Tambah Data Jurusan');
        $('#btn-form').text('Simpan');
        $('.needs-validation').attr('action','{{ route("jurusan.store") }}');
    }

    $('#modal-jurusan').on('hidden.bs.modal', function () {
        $('#form-jurusan').trigger('reset');
        $('#_method').remove();
    });
</script>
