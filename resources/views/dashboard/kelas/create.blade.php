<div class="modal fade" id="modal-kelas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Data Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                    <p><span class="text-danger">*</span> Wajib diisi</p>
                <p class="modal-text">
                    <div class="widget-content widget-content-area">
                        <form class="needs-validation" novalidate action="javascript:void(0);">
                            <div class="form-row">
                                <div class="col-12 mb-4">
                                    <label for="nama_kelas">Nama Kelas <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" name="nama_kelas" id="nama_kelas" placeholder="TI A" required>
                                    <div class="invalid-feedback">
                                        Kolom nama kelas tidak boleh kosong
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 mb-4">
                                    <label for="jurusan_id">Nama Jurusan <span class="text-danger">*</span></label>
                                    <select class="form-control select-jurusan" name="jurusan_id">
                                        <option>Teknik Informatika</option>
                                        <option>Teknik Pendingin</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Kolom nama jurusan tidak boleh kosong
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 mb-4">
                                    <label for="keterangan">Deskripsi <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" required cols="30" rows="5"></textarea>
                                    <div class="invalid-feedback">
                                        Kolom deskripsi tidak boleh kosong
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
