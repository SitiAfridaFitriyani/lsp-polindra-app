<script>
    function getData() {
        const table = $('#table-event-saya');
        const dataRoute = table.data('route');
        $.ajax({
            url: dataRoute,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                const data = response.data;
                const kelompokAsesorId = @json(request()->segment(2));

                const checklistObservasiRouteBaseURL = '{{ route("checklistObservasi.index", ":uuid") }}';
                const checklistObservasiRouteURL = `${checklistObservasiRouteBaseURL}&kelompok-asesor-id=${kelompokAsesorId}`;

                const fraplRouteBaseURL = '{{ route("frapl.index", ":uuid") }}';
                const fraplRouteURL = `${fraplRouteBaseURL}&kelompok-asesor-id=${kelompokAsesorId}`;

                const persetujuanAssesmenBaseURL = '{{ route("persetujuanAssesmen.index", ":uuid") }}';
                const persetujuanAssesmenURL = `${persetujuanAssesmenBaseURL}&kelompok-asesor-id=${kelompokAsesorId}`;

                const testAssesmenBaseURL = '{{ route("testAssesmen.index", ":uuid") }}';
                const testAssesmenURL = `${testAssesmenBaseURL}&kelompok-asesor-id=${kelompokAsesorId}`;

                table.DataTable({
                    "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                        "<'table-responsive'tr>" +
                        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                    "oLanguage": {
                        "oPaginate": {
                            "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                            "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                        },
                        "sInfo": "Showing page _PAGE_ of _PAGES_",
                        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                        "sSearchPlaceholder": "Search...",
                        "sLengthMenu": "Results :  _MENU_",
                    },
                    "stripeClasses": [],
                    "lengthMenu": [5, 10, 20, 50],
                    "pageLength": 5,
                    "destroy": true,
                    "data": data,
                    "columns": [
                        {
                            data: 'uuid',
                            render: function(data) {
                                const checklistObservasiRouteRendered = checklistObservasiRouteURL.replace(':uuid', data);
                                const fraplRouteRendered = fraplRouteURL.replace(':uuid', data);
                                const persetujuanAssesmenRendered = persetujuanAssesmenURL.replace(':uuid', data);
                                const daftarTestAssesmenRendered = testAssesmenURL.replace(':uuid', data);

                                return `
                                    <div class="dropdown">
                                        <a class="dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink10" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="More menu">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                        </a>
                                        <div class="dropdown-menu left" aria-labelledby="dropdownMenuLink10" style="will-change: transform; position: absolute; transform: translate3d(-141px, 19px, 0px); top: 0px; left: 0px;" x-placement="bottom-end">
                                            <a class="dropdown-item" href="${daftarTestAssesmenRendered}" title="Test Wawancara">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                                Test Wawancara
                                            </a>
                                            <a class="dropdown-item" href="${checklistObservasiRouteRendered}" title="Daftar Checklist Observasi">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                                                Daftar Checklist Observasi
                                            </a>
                                            <a class="dropdown-item" href="${fraplRouteRendered}" title="Daftar FRAPL">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book-open"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                                                Daftar FRAPL
                                            </a>
                                        </div>
                                    </div>`;
                            }
                        },
                        {
                            data: 'user',
                            render: function(data) {
                                return data ? data.name : 'N/A';
                            }
                        },
                        {
                            data: 'user',
                            render: function(data) {
                                return data ? data.email : 'N/A';
                            }
                        },
                        {
                            data: 'nim'
                        },
                        {
                            data: 'user',
                            render: function(data) {
                                return data ? data.phone : 'N/A';
                            }
                        },
                        {
                            data: 'user',
                            render: function(data) {
                                return data ? data.jenis_kelamin : 'N/A';
                            }
                        },
                        {
                            data: 'user',
                            render: function(data) {
                                return data ? data.address : 'N/A';
                            }
                        },
                    ]
                });
            },
            error: function(xhr, status, error) {
                snackBarAlert('Data gagal termuat', '#e7515a');
            }
        });

    }
</script>
{{-- <a class="dropdown-item" href="${persetujuanAssesmenRendered}" title="Daftar Lembar Persetujuan">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
    Daftar Lembar Persetujuan
</a>
 <a class="dropdown-item" href="javascript:void(0);" title="Daftar Rekaman Assesmen">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-server"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg>
    Daftar Rekaman Assesmen
</a>
<a class="dropdown-item" href="javascript:void(0);" title="Umpan Balik">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
    Umpan Balik
</a> --}}
