<script>
    document.addEventListener('DOMContentLoaded', function() {
        getData()
    });
    const unitKompetensiModalPath = $('#modal-unitKompetensi > .modal-dialog > .modal-content');
    $(".select-standar").select2({
        dropdownParent: unitKompetensiModalPath,
        tags: true,
        placeholder: "Pilih Jenis Standar",
        allowClear: true
    });

    $(".select-skema").select2({
        dropdownParent: unitKompetensiModalPath,
        tags: true,
        placeholder: "Pilih Skema",
        allowClear: true,
        ajax: {
        url: '{{ route('skema.list') }}',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
                return {
                    results: data.data.map(function (item) {
                        return {
                            id: item.uuid,
                            text: item.judul_skema
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
        $('#unitKompetensi-modal-title').text('Tambah Data Unit Kompetensi');
        $('#btn-form').text('Simpan');
        $('.needs-validation').attr('action','{{ route("unitKompetensi.store") }}');
    }

    $('#modal-unitKompetensi').on('hidden.bs.modal', function () {
        $('#form-unitKompetensi').trigger('reset');
        $('#skema_id').val(null).trigger('change');
        $('#jenis_standar').val(null).trigger('change');
        $('#_method').remove();
    });
</script>
