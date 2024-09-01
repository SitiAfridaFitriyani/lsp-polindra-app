@extends('layouts.app.main')
@section('title','Sertifikasi')
@section('content')
    <div class="row layout-top-spacing" id="cancel-row">
        <div class="col-lg-12">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <table id="table-event-saya" class="table style-3 table-hover" data-route="{{ route('sertifikasi.datatable', request()->query->keys()[0]) }}">
                        <thead>
                            <tr>
                                <th class="text-center dt-no-sorting">Action</th>
                                <th>Nama Peserta</th>
                                <th>Rekomendasi</th>
                                <th>Upload Sertifikat</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- @push('datatable')
        @include('dashboard.eventAdmin.component')
        @include('dashboard.eventAdmin.datatable')
    @endpush --}}
@endsection
