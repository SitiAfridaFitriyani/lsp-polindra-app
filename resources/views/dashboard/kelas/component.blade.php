<script>
    document.addEventListener('DOMContentLoaded', function() {
        getData()
    });
    const kelasModalPath = $('#modal-kelas > .modal-dialog > .modal-content');

    $(".select-jurusan").select2({
        dropdownParent: kelasModalPath,
        tags: true,
        placeholder: "Pilih Jurusan",
        allowClear: true,
        ajax: {
        url: '{{ route('jurusan.list') }}',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
                return {
                    results: data.data.map(function (item) {
                        return {
                            id: item.uuid,
                            text: item.nama_jurusan
                        };
                    })
                };
            },
            cache: true
        }
    });

    function modalFormCreate(elemen)
    {
        const targetModal = elemen.getAttribute('data-target');
        $(`${targetModal}`).modal('show');
        $('#kelas-modal-title').text('Tambah Data Kelas');
        $('#btn-form').text('Simpan');
        $('.needs-validation').attr('action','{{ route("kelas.store") }}');
    }

    $('#modal-kelas').on('hidden.bs.modal', function () {
        $('#form-kelas').trigger('reset');
        $('#jurusan_id').val(null).trigger('change');
        $('#_method').remove();
    });
</script>
