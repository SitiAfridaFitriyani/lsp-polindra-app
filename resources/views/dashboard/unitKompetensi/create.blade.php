<div class="modal fade" id="modal-skema" data-key-modal="modal-skema" tabindex="-1" role="dialog" aria-labelledby="skema-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="skema-modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                    <p><span class="text-danger">*</span> Wajib diisi</p>
                <p class="modal-text">
                    <div class="widget-content widget-content-area">
                        <form class="needs-validation" id="form-skema" novalidate method="POST" action="">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="no_skema">Nomor Skema <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('no_skema') is-invalid @enderror" name="no_skema" id="no_skema" required>
                                    <div class="invalid-feedback">
                                        Kolom nomor skema tidak boleh kosong
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="kode_skema">Kode Skema <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('kode_skema') is-invalid @enderror" name="kode_skema" id="kode_skema" required>
                                    <div class="invalid-feedback">
                                        Kolom kode skema tidak boleh kosong
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="judul_skema">Judul Skema <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('judul_skema') is-invalid @enderror" name="judul_skema" id="judul_skema" required>
                                    <div class="invalid-feedback">
                                        Kolom kode skema tidak boleh kosong
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="event_id">Event <span class="text-danger">*</span></label>
                                    <select class="form-control select-event @error('event_id') is-invalid @enderror" name="event_id" id="event_id" required>
                                    </select>
                                    <div class="invalid-feedback" style="margin-top: -20px">
                                        Kolom event tidak boleh kosong
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 mb-4">
                                    <label for="jenis_standar">Jenis Standar <span class="text-danger">*</span></label>
                                    <select class="form-control select-standar @error('jenis_standar') is-invalid @enderror" name="jenis_standar" id="jenis_standar" required>
                                        <option value="" selected disabled>Please select</option>
                                        <option value="KKNI">KKNI</option>
                                        <option value="Okupasi">Okupasi</option>
                                        <option value="Klaster">Klaster</option>
                                    </select>
                                    <div class="invalid-feedback" style="margin-top: -20px">
                                        Kolom jenis standar tidak boleh kosong
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary mt-3 text-center" type="submit">Simpan</button>
                        </form>
                    </div>
                </p>
            </div>
        </div>
    </div>
</div>
