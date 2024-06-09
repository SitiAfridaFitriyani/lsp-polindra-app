<script>
    function handleEdit(elemen) {
        $('#berkasPemohon-modal-title').text('Edit Data Berkas Pemohon');
        $('#btn-form').text('Update');
        const editRoute = elemen.getAttribute('data-route');
        const uuid = elemen.getAttribute('data-uuid');
        const updateRoute = '{{ route("berkasPemohon.update", [":uuid"]) }}';
        const form = $('.needs-validation');
        form.attr('action', updateRoute.replace(':uuid', uuid));
        form.attr('data-method','PUT');

        if ($('#_method').length === 0) {
            form.append('<input type="hidden" name="_method" id="_method" value="PUT">');
        }
        $('#modal-berkasPemohon').modal('show');
        $.ajax({
            url: editRoute,
            type: 'GET',
            success: function(response) {
                const data = response.data;

                $('#nama_berkas').val(data.nama_berkas);
                $('#skema_id').val(data.skema_id).trigger('change');
            },
            error: function(xhr, status, error) {
                snackBarAlert('Data gagal dimuat', '#e7515a');
            }
        });
    }
</script>
