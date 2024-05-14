@extends('layouts.app.main')
@section('title','Event')
@section('content')
    <div class="row layout-top-spacing" id="cancel-row">
        <div id="breadcrumbDefault" class="col-xl-12 col-lg-12 layout-spacing">
            <nav class="breadcrumb-one" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
                    <li class="breadcrumb-item dropdown">
                        <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Perangkat Assesmen
                        </a>
                        <div class="dropdown-menu right" aria-labelledby="pendingTask" style="will-change: transform; position: absolute; transform: translate3d(105px, 0, 0px); top: 0px; left: 0px;">
                            <a class="dropdown-item" href="{{ route('skema.index') }}">Skema</a>
                            <a class="dropdown-item" href="{{ route('unitKompetensi.index') }}">Unit Kompetensi</a>
                            <a class="dropdown-item" href="{{ route('elemen.index') }}">Elemen</a>
                            <a class="dropdown-item" href="{{ route('kriteriaUnjukKerja.index') }}">Kriteria Unjuk Kerja</a>
                            <a class="dropdown-item" href="{{ route('berkasPermohonan.index') }}">Berkas Permohonan</a>
                            <a class="dropdown-item" href="{{ route('ujianTulis.index') }}">Ujian Tulis</a>
                            <a class="dropdown-item" href="{{ route('ujianPraktek.index') }}">Ujian Praktek</a>
                        </div>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Event</li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-12">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary mb-2 mr-2" data-toggle="modal" data-target="#modal-event">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                </button>
                <button class="btn btn-transparent mb-2 mr-2 border dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                </button>
                <div class="dropdown-menu">
                    <a href="javascript:void(0);" class="dropdown-item">Export PDF</a>
                    <a href="javascript:void(0);" class="dropdown-item">Export Excel</a>
                </div>
            </div>
            @include('dashboard.event.create')
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <table id="table-event" class="table style-3 table-hover" data-route="{{ route('event.datatable') }}">
                        <thead>
                            <tr>
                                <th>Nama Event</th>
                                <th>TUK</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Deskripsi</th>
                                <th class="text-center dt-no-sorting">Action</th>
                            </tr>
                        </thead>
                    </table>
                    @include('dashboard.event.listSkema')
                </div>
            </div>
        </div>
    </div>
    @push('datatable')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                getData()
            });
            const kelasModal = $('#modal-event > .modal-dialog > .modal-content');
            $(".select-tuk").select2({
                dropdownParent: kelasModal,
                tags: true,
                placeholder: "Pilih TUK",
                allowClear: true
            });

            $('#modal-event').on('shown.bs.modal', function () {
                flatpickr(document.getElementById('event_mulai'), {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                });
                flatpickr(document.getElementById('event_selesai'), {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                });
            });
        </script>
        @include('dashboard.event.datatable')

        <script>
            function handleListSkema(elemen) {
                const modalbs = elemen.getAttribute('data-modal');
                const dataRoute = elemen.getAttribute('data-route');
                const eventName = elemen.getAttribute('data-eventName');
                $.ajax({
                    url: dataRoute,
                    type: 'GET',
                    success: function(response) {
                        const data = response.data;
                        $('#table-list-skema tbody').empty();
                        data.forEach(function(item) {
                            var row = $('<tr>');
                            row.append($('<td>').text(item.no_skema));
                            row.append($('<td>').text(item.kode_skema));
                            row.append($('<td>').text(item.judul_skema));
                            row.append($('<td>').text(item.jenis_standar));
                            row.append($('<td class="text-center">').html(
                                `<ul class="table-controls list-unstyled">
                                    <li>
                                        <a href="javascript:void(0);" onclick="lihatSkema(${item.id})" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="Lihat data" data-original-title="Lihat Data">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                        </a>
                                    </li>
                                </ul>`
                            ));
                            $('#table-list-skema tbody').append(row);
                        });

                        $('#modal-title-event').text('Daftar Skema [' + eventName + ']');
                        $('#' + modalbs).modal('show');
                    },
                    error: function(xhr, status, error) {
                        snackBarAlert('Data gagal termuat', '#e7515a');
                    }
                });
            }
        </script>
    @endpush
@endsection
