<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{KelompokAsesor,FRAPL02,Asesi};
use App\Http\Requests\UpdateFRAPL02Request;
use Illuminate\Support\Facades\{Storage,Validator,Auth,DB,Gate};

class FRAPL02Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $uuid = request()->query->keys()[0];
        if(Gate::allows('asesor')) {
            $uuid = explode('?', $uuid)[0];
        }
        $query = KelompokAsesor::with(['skema.unitKompetensi.elemen','event','kelas','asesor.user']);
        $kelompokAsesorNotIn = (clone $query)->where('uuid','!=',$uuid)->get();
        $kelompokAsesor = $query->firstWhere('uuid',$uuid);

        return view('dashboard.frapl.frapl02.index',compact('kelompokAsesor','kelompokAsesorNotIn'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'signatureAsesi' => ['nullable'],
            'berkasFilePemohon' => ['nullable'],
            'statusAssesmenMandiri' => ['required'],
            'kelompok-asesor-uuid' => ['required', 'exists:t_kelompok_asesor,uuid']
        ], $this->messageValidation());

        $kelompokAsesor = KelompokAsesor::firstWhere('uuid', request('kelompok-asesor-uuid'));
        if(empty($kelompokAsesor)) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Data kelompok asesor tidak ditemukan'], 404);
        }

        $existingData = FRAPL02::firstWhere([
            ['asesi_id', Auth::user()->asesi['id']],
            ['kelompok_asesor_id', $kelompokAsesor['id']]
        ]);

        if(empty($existingData)) {
            $request->validate([
                'signatureAsesi' => ['required'],
                'berkasFilePemohon' => ['required']
            ],$this->messageValidation());
        } else {
            return response()->json(['status' => 'error', 'message' => 'Kamu sudah melakukan submit sebelumnya'], 500);
        }

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();
        try {
            DB::beginTransaction();

            // TTD Asesi
            $signatureAsesi = $request->input('signatureAsesi');
            if($signatureAsesi) {
                if(!empty($existingData) && $existingData['ttd_asesi'] != null && Storage::exists($existingData['ttd_asesi'])) {
                    Storage::delete($existingData['ttd_asesi']);
                }
                $imageName = time() . '.png';
                $path = public_path('storage/asesi_signatureFRAPL02/' . $imageName);
                $signatureAsesi = str_replace('data:image/png;base64,', '', $signatureAsesi);
                $signatureAsesi = str_replace(' ', '+', $signatureAsesi);
                file_put_contents($path, base64_decode($signatureAsesi));
                $validated['ttd_asesi'] = 'asesi_signatureFRAPL02/'.$imageName;
            } else {
                $validated['ttd_asesi'] = $existingData['ttd_asesi'];
            }

            if(isset($validated['berkasFilePemohon']) && !empty($existingData)) {
                $jcdBerkas = json_decode($existingData['berkas_pemohon_asesi'],true);
                foreach($jcdBerkas as $berkas) {
                    Storage::delete($berkas['berkas']);
                }
                $existingData->update(['berkas_pemohon_asesi' => json_encode([])]);
            }

            // Loop Berkas & File
            $arrStatusBerkas = [];
            if (isset($validated['statusAssesmenMandiri'])) :
                foreach ($validated['statusAssesmenMandiri'] as $keterangan) {
                    $arrStatusBerkas[] = [
                        'keterangan' => $keterangan
                    ];
                }
            endif;
            $arrFileBerkas = [];
            if (isset($validated['berkasFilePemohon'])) :
                foreach ($validated['berkasFilePemohon'] as $b) {
                    $path = $b->store('berkas_frpapl02');
                    $arrFileBerkas[] = [
                        'berkas' => $path
                    ];
                }
                for ($i = 0; $i < count($validated['berkasFilePemohon']); $i++) {
                    $mergedBerkas[] = array_merge($arrStatusBerkas[$i], $arrFileBerkas[$i]);
                }
            else:
                $jcdBerkas = json_decode($existingData['assesmen_mandiri'],true);
                $mergedBerkas = $jcdBerkas;
            endif;


            $validated['assesmen_mandiri'] = json_encode($mergedBerkas);
            $validated['asesi_id'] = Auth::user()->asesi['id'];
            $validated['tgl_ttd_asesi'] = now();

            $result = FRAPL02::updateOrCreate([
                    'asesi_id' => Auth::user()->asesi['id'],
                    'kelompok_asesor_id' => $kelompokAsesor['id']
                ],
                [
                    'ttd_asesi' => $validated['ttd_asesi'],
                    'assesmen_mandiri' => $validated['assesmen_mandiri'],
                    'asesi_id' => $validated['asesi_id'],
                    'tgl_ttd_asesi' => $validated['tgl_ttd_asesi']
                ]);
            if ($result) {
                DB::commit();
                return response()->json(['status' => 'success', 'code' => '200', 'message' => 'Data FRAPL-02 berhasil ditambahkan'], 200);
            } else {
                DB::rollBack();
                return response()->json(['status' => 'error' ,'code' => '500', 'message' => 'Server Error 500'], 500);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error','code' => '500', 'message' => $th->getMessage()], 500);
        }
    }

    public function asesorSignature(Request $request)
    {
        $signatureAsesor = $request->input('signature');
        $asesiUuid = $request->asesi_id;
        $kelompokAsesorUuid = $request->kelompok_asesor;
        DB::beginTransaction();
        $asesi = Asesi::firstWhere('uuid',$asesiUuid);
        $kelompokAsesor = KelompokAsesor::firstWhere('uuid',$kelompokAsesorUuid);
        if(empty($asesi) || empty($kelompokAsesor)) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
        }

        $frapl02 = FRAPL02::firstWhere([
            ['asesi_id',$asesi['id']],
            ['kelompok_asesor_id',$kelompokAsesor['id']]
        ]);

        if($signatureAsesor) {
            if(!empty($frapl02) && $frapl02['ttd_asesor'] != null && Storage::exists($frapl02['ttd_asesor'])) {
                Storage::delete($frapl02['ttd_asesor']);
            }
            $imageName = time() . '.png';
            $path = public_path('storage/asesor_signatureFRAPL02/' . $imageName);
            $signatureAsesor = str_replace('data:image/png;base64,', '', $signatureAsesor);
            $signatureAsesor = str_replace(' ', '+', $signatureAsesor);
            file_put_contents($path, base64_decode($signatureAsesor));
            $resultTtdAsesor = 'asesor_signatureFRAPL02/'.$imageName;
        } else {
            $resultTtdAsesor = $frapl02['ttd_asesor'];
        }

        $result = $frapl02->update([
            'tgl_ttd_asesor' => now(),
            'ttd_asesor' => $resultTtdAsesor
        ]);
        if ($result) {
            DB::commit();
            return response()->json(['status' => 'success', 'code' => '200', 'message' => 'Data FRAPL-02 berhasil ditandatangani'], 200);
        } else {
            DB::rollBack();
            return response()->json(['status' => 'error' ,'code' => '500', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FRAPL02 $fRAPL02)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FRAPL02 $fRAPL02)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFRAPL02Request $request, FRAPL02 $fRAPL02)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FRAPL02 $fRAPL02)
    {
        //
    }

    public function showByKelompokAsesor()
    {
        $kelompokAsesorUuid = request('kelompok_asesor');

        $kelompokAsesor = KelompokAsesor::firstWhere('uuid', $kelompokAsesorUuid);
        if(empty($kelompokAsesor)) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Data kelompok asesor tidak ditemukan'], 404);
        }

        if(Gate::allows('asesi')) {
            $asesiId = Auth::user()->asesi['id'];
        } elseif (Gate::allows('asesor')) {
            $asesiId = Asesi::firstWhere('uuid',request('asesi_id'))->pluck('id');
        }

        $data = FRAPL02::firstWhere([
            ['asesi_id', $asesiId],
            ['kelompok_asesor_id', $kelompokAsesor['id']]
        ]);
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
}
