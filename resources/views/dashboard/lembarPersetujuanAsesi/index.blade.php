@extends('layouts.app.main')
@section('title','Persetujuan Kerahasiaan')
@section('content')
    <div class="row layout-top-spacing" id="cancel-row">
        <div id="breadcrumbDefault" class="col-xl-12 col-lg-12 layout-spacing">
            <nav class="breadcrumb-one" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
                    <li class="breadcrumb-item dropdown">
                        <a class="dropdown-toggle" href="{{ route('event-asesi.show', $kelompokAsesor['uuid']) }}" role="button" id="pendingTask" aria-haspopup="true" aria-expanded="true">
                            Event Saya
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Lembar Persetujuan Kerahasiaan</li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-12">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th style="border: none !important;">
                                        FR.AK.01. PERSETUJUAN ASESMEN DAN KERAHASIAAN
                                    </th>
                                </tr>
                                <tr style="border: none !important;">
                                    <th>Skema Sertifikasi</th>
                                    <td>:</td>
                                    <td>{{ $kelompokAsesor->skema['jenis_standar'] }}</td>
                                </tr>
                                <tr style="border: none !important;">
                                    <th>Nomor Skema</th>
                                    <td>:</td>
                                    <td>{{ $kelompokAsesor->skema['no_skema'] }}</td>
                                </tr>
                                <tr style="border: none !important;">
                                    <th>Judul Skema</th>
                                    <td>:</td>
                                    <td>{{ $kelompokAsesor->skema['judul_skema'] }}</td>
                                </tr>
                                <tr style="border: none !important;">
                                    <th>TUK</th>
                                    <td>:</td>
                                    <td>{{ $kelompokAsesor->event['tuk'] }}</td>
                                </tr>
                                <tr style="border: none !important;">
                                    <th>Pelaksanaan Assesmen</th>
                                </tr>
                                <tr style="border: none !important;">
                                    <td>Hari/Tanggal</td>
                                    <td>:</td>
                                    <td>{{ \Carbon\Carbon::parse($kelompokAsesor->event['event_mulai'])->isoFormat('dddd, DD MMMM Y') }}</td>
                                </tr>
                                <tr style="border: none !important;">
                                    <td>Waktu</td>
                                    <td>:</td>
                                    <td>{{ \Carbon\Carbon::parse($kelompokAsesor->event['event_mulai'])->isoFormat('HH:mm') }} WIB</td>
                                </tr>
                                <tr style="border: none !important;">
                                    <td>TUK</td>
                                    <td>:</td>
                                    <td>{{ $kelompokAsesor->event['tuk'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr style="border: none !important;">
                                    <th>Bukti Kelengkapan</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <form class="needs-validation" id="form-berkas-persetujuan" novalidate method="POST" action="{{ route('persetujuanAssesmen.store', ['uuid' => $kelompokAsesor['uuid']]) }}">
                        @csrf
                        <input type="hidden" name="signatureAsesi" id="signatureAsesi" name="signatureAsesi">
                        <input type="hidden" name="signatureAsesor" id="signatureAsesor" name="signatureAsesor">
                        <div class="d-flex">
                            <div class="ml-3">
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input" id="ckportofolio" name="berkas[1]ckPortofolio" value="TL : Verifikasi Portofolio">
                                    <label style="cursor:pointer" class="custom-control-label" for="ckportofolio">TL : Verifikasi Portofolio</label>
                                </div>
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input" id="ckoberservasi" name="berkas[2]observasi" value="L : Observasi">
                                    <label style="cursor:pointer" class="custom-control-label" for="ckoberservasi">L : Observasi</label>
                                </div>
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input" id="cktestTulis" name="berkas[3]testTulis" value="T: Hasil Tes Tulis">
                                    <label style="cursor:pointer" class="custom-control-label" for="cktestTulis">T: Hasil Tes Tulis</label>
                                </div>
                            </div>
                            <div class="ml-5">
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input" id="cktestLisan" name="berkas[4]testLisan" value="T: Hasil Tes Lisan">
                                    <label style="cursor:pointer" class="custom-control-label" for="cktestLisan">T: Hasil Tes Lisan</label>
                                </div>
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input" id="cktestWawancara" name="berkas[5]testWawancara" value="T: Hasil Tes Wawancara">
                                    <label style="cursor:pointer" class="custom-control-label" for="cktestWawancara">T: Hasil Tes Wawancara</label>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr style="border: none !important;">
                                        <th>Tanda Tangan Berkas</th>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="d-flex mb-3">
                                <div class="ttd-asesi text-center">
                                    <div style="margin-left:12px; border: 1px solid black; width: 130px; height: 60px;">
                                        <div id="available-ttdAsesi"></div>
                                    </div>
                                    <br>
                                    @can('asesi')
                                        <span class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#create-ttd-asesi"> Tanda Tangan Asesi</span>
                                    @else
                                        <span class="text-primary">Tanda Tangan Asesi</span>
                                    @endcan
                                </div>
                                <div class="ttd-asesor text-center ml-5">
                                    <div style="margin-left:17px; border: 1px solid black; width: 130px; height: 60px;">
                                        <div id="available-ttdAsesor"></div>
                                    </div>
                                    <br>
                                    @can('asesor')
                                        <span class="ml-1 btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#create-ttd-asesor"> Tanda Tangan Asesor</span>
                                    @else
                                        <span class="text-primary ml-2">Tanda Tangan Asesor</span>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary mt-3" id="btn-form" type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @can('asesi')
        {{-- MODAL TTD ASESI --}}
        <div class="modal fade" id="create-ttd-asesi" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Tanda Tangan Asesi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body text-center">
                            <canvas id="signatureCanvasAsesi" width="400" height="200" style="border: 1px solid black;"></canvas>
                            <div class="modal-footer bg-transparent d-flex justify-content-center">
                                <button onclick="clearCanvasAsesi()" id="clearCanvasAsesiButton" class="btn btn-outline-danger">Clear Canvas</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- TTD ASESI SCRIPT --}}
        <script>
            var canvasAsesi = document.getElementById('signatureCanvasAsesi');
            var ctxAsesi = canvasAsesi.getContext('2d');
            var isDrawingAsesi = false;
            var lastXAsesi = 0;
            var lastYAsesi = 0;
            var inputSignatureAsesi = document.getElementById('signatureAsesi');
            canvasAsesi.addEventListener('mousedown', (e) => {
                isDrawingAsesi = true;
                [lastXAsesi, lastYAsesi] = [e.offsetX, e.offsetY];
            });
            canvasAsesi.addEventListener('mousemove', draw);
            canvasAsesi.addEventListener('mouseup', () => {
                isDrawingAsesi = false;
                updateSignatureInputAsesi();
            });
            canvasAsesi.addEventListener('mouseout', () => {
                isDrawingAsesi = false;
                updateSignatureInputAsesi();
            });
            function draw(e) {
                if (!isDrawingAsesi) return;
                ctxAsesi.beginPath();
                ctxAsesi.moveTo(lastXAsesi, lastYAsesi);
                ctxAsesi.lineTo(e.offsetX, e.offsetY);
                ctxAsesi.stroke();
                [lastXAsesi, lastYAsesi] = [e.offsetX, e.offsetY];
            }
            function updateSignatureInputAsesi() {
                inputSignatureAsesi.value = canvasAsesi.toDataURL();
            }
            function clearCanvasAsesi() {
                inputSignatureAsesi.value = "";
                ctxAsesi.clearRect(0, 0, canvasAsesi.width, canvasAsesi.height);
            }
        </script>
    @endcan
    @can('asesor')
        {{-- MODAL TTD ASESOR --}}
        <div class="modal fade" id="create-ttd-asesor" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Tanda Tangan Asesor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body text-center">
                            <canvas id="signatureCanvasAsesor" width="400" height="200" style="border: 1px solid black;"></canvas>
                            <div class="modal-footer bg-transparent d-flex justify-content-center">
                                <button onclick="clearCanvasAsesor()" id="clearCanvasAsesorButton" class="btn btn-outline-danger">Clear Canvas</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- TTD ASESOR SCRIPT --}}
        <script>
            var canvasAsesor = document.getElementById('signatureCanvasAsesor');
            var ctxAsesor = canvasAsesor.getContext('2d');
            var isDrawingAsesor = false;
            var lastXAsesor = 0;
            var lastYAsesor = 0;
            var inputSignatureAsesor = document.getElementById('signatureAsesor');
            canvasAsesor.addEventListener('mousedown', (e) => {
                isDrawingAsesor = true;
                [lastXAsesor, lastYAsesor] = [e.offsetX, e.offsetY];
            });
            canvasAsesor.addEventListener('mousemove', draw);
            canvasAsesor.addEventListener('mouseup', () => {
                isDrawingAsesor = false;
                updateSignatureInputAsesor();
            });
            canvasAsesor.addEventListener('mouseout', () => {
                isDrawingAsesor = false;
                updateSignatureInputAsesor();
            });
            function draw(e) {
                if (!isDrawingAsesor) return;
                ctxAsesor.beginPath();
                ctxAsesor.moveTo(lastXAsesor, lastYAsesor);
                ctxAsesor.lineTo(e.offsetX, e.offsetY);
                ctxAsesor.stroke();
                [lastXAsesor, lastYAsesor] = [e.offsetX, e.offsetY];
            }
            function updateSignatureInputAsesor() {
                inputSignatureAsesor.value = canvasAsesor.toDataURL();
            }
            function clearCanvasAsesor() {
                inputSignatureAsesor.value = "";
                ctxAsesor.clearRect(0, 0, canvasAsesor.width, canvasAsesor.height);
            }
        </script>
    @endcan
    {{-- GET DATA --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            getData();
        });
        function getData() {
            $.ajax({
                url: "{{ route('persetujuanAssesmen.show-by-kelompokAsesor') }}",
                type: 'GET',
                data: {kelompok_asesor: @json($kelompokAsesor['uuid'])},
                success: function(response) {
                    @can('asesi')
                        document.getElementById('clearCanvasAsesiButton').click();
                    @endcan
                    @can('asesor')
                        document.getElementById('clearCanvasAsesorButton').click();
                    @endcan
                    const data = response.data;
                    const berkas = JSON.parse(data.berkas);
                    const urlTtdAsesi = `{{ asset('storage/${data.ttd_asesi}') }}`;

                    if(data.ttd_asesi) {
                        $('#available-ttdAsesi').html(`<img style="width: 130px; height: 60px;" src="${urlTtdAsesi}" style="width:70px; height:70px"/>`);
                    }

                    berkas.forEach(item => {
                        if (item === "TL : Verifikasi Portofolio") {
                            document.getElementById('ckportofolio').checked = true;
                        }
                        if (item === "L : Observasi") {
                            document.getElementById('ckoberservasi').checked = true;
                        }
                        if (item === "T: Hasil Tes Tulis") {
                            document.getElementById('cktestTulis').checked = true;
                        }
                        if (item === "T: Hasil Tes Lisan") {
                            document.getElementById('cktestLisan').checked = true;
                        }
                        if (item === "T: Hasil Tes Wawancara") {
                            document.getElementById('cktestWawancara').checked = true;
                        }
                    });
                },
                error: function(xhr, status, error) {
                    snackBarAlert('Data gagal dimuat', '#e7515a');
                }
            });
        }
    </script>
@endsection
