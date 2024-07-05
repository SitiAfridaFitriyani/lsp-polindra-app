@extends('layouts.app.main')
@section('title','Daftar FRAPL Assesmen')
@section('content')
    <div class="row layout-top-spacing" id="cancel-row">
        <div id="breadcrumbDefault" class="col-xl-12 col-lg-12 layout-spacing">
            <nav class="breadcrumb-one" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
                    <li class="breadcrumb-item dropdown">
                        <a class="dropdown-toggle" href="javascript:void(0);" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Event Saya
                        </a>
                        <div class="dropdown-menu right" aria-labelledby="pendingTask" style="will-change: transform; position: absolute; transform: translate3d(105px, 0, 0px); top: 0px; left: 0px;">
                            @forelse($kelompokAsesorNotIn as $data)
                                <a class="dropdown-item" href="{{ route('event-asesi.show', $data['uuid']) }}">{{ $data->event['nama_event'] }}</a>
                            @empty
                                <a class="dropdown-item" href="javascript:void(0);">Tidak ada data</a>
                            @endforelse
                        </div>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar FRAPL Assesmen</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 layout-spacing">
            <div class="widget widget-card-two h-100">
                <div class="widget-content">
                    <div class="media">
                        <div class="w-img">
                            @php
                                $image = 'admin/assets/img/nopict.png';
                                if(Auth::user()->photo != null && Storage::exists(Auth::user()->photo)) {
                                    $image = 'storage/'. Auth::user()->photo;
                                }
                            @endphp
                            <img src="{{ asset($image) }}" alt="avatar">
                        </div>
                        <div class="media-body">
                            <h6>{{ Auth::user()->name }}</h6>
                            <p class="meta-date-time">{{ Auth::user()->role }}</p>
                        </div>
                    </div>

                    <div class="card-bottom-section">
                        <h5>FRAPL-01. PERMOHONAN SERTIFIKASI KOMPETENSI</h5>
                        <ul style="list-style-type: decimal; text-align: left;">
                            <li>Rincian Data Pemohon Sertifikasi</li>
                            <li>Data Sertifikasi</li>
                            <li>Bukti Kelengkapan Pemohon</li>
                        </ul>
                        <a href="{{ route('frapl01.index', $kelompokAsesor['uuid']) }}" class="btn" style="margin-top: 79px">Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 layout-spacing">
            <div class="widget widget-card-two h-100">
                <div class="widget-content d-flex flex-column">
                    <div class="media">
                        <div class="w-img">
                            @php
                                $image = 'admin/assets/img/nopict.png';
                                if(Auth::user()->photo != null && Storage::exists(Auth::user()->photo)) {
                                    $image = 'storage/'. Auth::user()->photo;
                                }
                            @endphp
                            <img src="{{ asset($image) }}" alt="avatar">
                        </div>
                        <div class="media-body">
                            <h6>{{ Auth::user()->name }}</h6>
                            <p class="meta-date-time">{{ Auth::user()->role }}</p>
                        </div>
                    </div>
                    <div class="card-bottom-section">
                        <h5>FRAPL-02. ASESMEN MANDIRI</h5>
                        <ul style="list-style-type: decimal; text-align: left;">
                            <li>Baca setiap pertanyaan di kolom sebelah kiri</li>
                            <li>Beri tanda centang (✅) pada kotak jika Anda yakin dapat melakukan tugas yang dijelaskan.</li>
                            <li>Isi kolom di sebelah kanan dengan mendaftar bukti yang Anda miliki untuk menunjukkan bahwa Anda melakukan tugas-tugas ini.</li>
                        </ul>
                        <a href="{{ route('frapl02.index',$kelompokAsesor['uuid']) }}" class="btn mt-auto">Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
