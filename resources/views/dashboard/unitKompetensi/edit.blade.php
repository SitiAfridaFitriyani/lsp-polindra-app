<script>
    function handleEdit(elemen) {
        $('#unitKompetensi-modal-title').text('Edit Data Unit Kompetensi');
        $('#btn-form').text('Update');
        const editRoute = elemen.getAttribute('data-route');
        const uuid = elemen.getAttribute('data-uuid');
        const updateRoute = '{{ route("unitKompetensi.update", [":uuid"]) }}';
        const form = $('.needs-validation');
        form.attr('action', updateRoute.replace(':uuid', uuid));
        form.attr('data-method','PUT');

        if ($('#_method').length === 0) {
            form.append('<input type="hidden" name="_method" id="_method" value="PUT">');
        }
        $('#modal-unitKompetensi').modal('show');
        $.ajax({
            url: editRoute,
            type: 'GET',
            success: function(response) {
                const data = response.data;

                $('#kode_unit').val(data.kode_unit);
                $('#judul_unit').val(data.judul_unit);
                $('#jenis_standar').val(data.jenis_standar).trigger('change');
                $('#skema_id').val(data.skema_id).trigger('change');
            },
            error: function(xhr, status, error) {
                snackBarAlert('Data gagal dimuat', '#e7515a');
            }
        });
    }
</script>
