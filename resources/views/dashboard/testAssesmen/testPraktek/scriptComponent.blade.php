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
                url: "{{ route('userTestPraktek.show-by-kelompokAsesor') }}",
                type: 'GET',
                data: {kelompok_asesor: @json($kelompokAsesor['uuid'])},
                success: function(response) {
                    // Cleared Canvas after get Data
                    @can('asesi')
                        document.getElementById('clearCanvasAsesiButton').click();
                    @endcan
                    @can('asesor')
                        document.getElementById('clearCanvasAsesorButton').click();
                    @endcan
                    // Variabel
                    const data = response.data;
                    if (window.jawabanTestPraktek) {
                        window.jawabanTestPraktek.setData(data.jawaban);
                    }
                    const urlTtdAsesi = `{{ asset('storage/${data.ttd_asesi}') }}`;
                    // TTD Asesi
                    if(data.ttd_asesi) {
                        $('#available-ttdAsesi').html(`<img style="width: 130px; height: 60px;" src="${urlTtdAsesi}" style="width:70px; height:70px"/>`);
                    }
                },
                error: function(xhr, status, error) {
                    snackBarAlert('Data gagal dimuat', '#e7515a');
                }
            });
        }
    </script>
