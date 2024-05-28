<script>
    function handleListUnitKompetensi(elemen) {
        const modalbs = elemen.getAttribute('data-modal');
        const dataRoute = elemen.getAttribute('data-route');
        const skemaName = elemen.getAttribute('data-skemaName');
        $.ajax({
            url: dataRoute,
            type: 'GET',
            success: function(response) {
                const data = response.data;
                $('#table-list-unitKompetensi tbody').empty();
                $('#modal-title-unitKompetensi').text('Daftar Unit Kompetensi [' + skemaName + ']');
                $('#' + modalbs).modal('show');

                if(data.length > 0) {
                    $('#empty-dataTable').addClass('d-none');
                    data.forEach(function(item) {
                        var row = $('<tr>');
                        row.append($('<td>').text(item.kode_unit));
                        row.append($('<td>').text(item.judul_unit));
                        row.append($('<td>').text(item.jenis_standar));
                        row.append($('<td class="text-center">').html(
                            `<ul class="table-controls list-unstyled">
                                <li>
                                    <a href="javascript:void(0);" onclick="lihatUnitKompetensi(${item.id})" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="Lihat data" data-original-title="Lihat Data">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    </a>
                                </li>
                            </ul>`
                        ));
                        $('#table-list-unitKompetensi tbody').append(row);
                    });
                } else {
                    $('#empty-dataTable').removeClass('d-none').addClass('text-center');
                }
            },
            error: function(xhr, status, error) {
                snackBarAlert('Data gagal termuat', '#e7515a');
            }
        });
    }
</script>
