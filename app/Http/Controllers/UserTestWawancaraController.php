<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth,DB,Validator,Storage,Gate};
use App\Models\{Asesi,UserTestWawancara,KelompokAsesor,TestWawancara};

class UserTestWawancaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fullQueryString = request()->getQueryString();
        $uuid = request()->query->keys()[0];
        $query = KelompokAsesor::with(['skema.testPraktek','event','kelas','asesor.user']);
        $kelompokAsesorNotIn = (clone $query)->where('uuid','!=',$uuid)->get();
        $kelompokAsesor = $query->firstWhere('uuid',$uuid);
        $ujianWawancara = TestWawancara::with(['kriteriaUnjukKerja','unitKompetensi'])->latest()->get();
        return view('dashboard.testAssesmen.testWawancara.index',compact('kelompokAsesor','kelompokAsesorNotIn','ujianWawancara'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'signatureAsesor' => ['nullable'],
            'tanggapan' => ['array'],
            'status_assesmen' => ['required','array'],
            'umpan_balik' => ['array'],
            'uuid' => ['required', 'exists:t_kelompok_asesor,uuid'],
            'asesi-id' => ['required','exists:m_asesi,uuid']
        ], $this->messageValidation());

        $kelompokAsesor = KelompokAsesor::firstWhere('uuid', $request->uuid);
        $asesi = Asesi::firstWhere('uuid',request('asesi-id'));

        if(empty($kelompokAsesor)) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Data kelompok asesor tidak ditemukan'], 404);
        }
        if(empty($asesi)) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Data asesi tidak ditemukan'], 404);
        }

        $existingData = UserTestWawancara::firstWhere([
            ['asesi_id',$asesi['id']],
            ['kelompok_asesor_id',$kelompokAsesor['id']]
        ]);

        if(empty($existingData)) {
            $request->validate([
                'signatureAsesor' => ['required']
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
            $arrTanggapan = [];
            $arrUmpanBalik = [];
            $arrStatusObservasi = [];
            $arrMerged =[];

            // TTD Asesor
            $signatureAsesor = $request->input('signatureAsesor');
            if($signatureAsesor) {
                if(!empty($existingData) && $existingData['ttd_asesor'] != null && Storage::exists($existingData['ttd_asesor'])) {
                    Storage::delete($existingData['ttd_asesor']);
                }
                $imageName = time() . '.png';
                $path = public_path('storage/asesor_signatureTestWawancara/' . $imageName);
                $signatureAsesor = str_replace('data:image/png;base64,', '', $signatureAsesor);
                $signatureAsesor = str_replace(' ', '+', $signatureAsesor);
                file_put_contents($path, base64_decode($signatureAsesor));
                $validated['ttd_asesor'] = 'asesor_signatureTestWawancara/'.$imageName;
            } else {
                $validated['ttd_asesor'] = $existingData['ttd_asesor'];
            }

            if($validated['tanggapan']) {
                foreach($validated['tanggapan'] as $wawancaraId => $tgp) {
                    $arrTanggapan [] = [
                        'test_wawancara_id' => $wawancaraId,
                        'tanggapan' => $tgp
                    ];
                }
            }
            if($validated['umpan_balik']) {
                foreach($validated['umpan_balik'] as $wawancaraId => $ub) {
                    $arrUmpanBalik [] = [
                        'test_wawancara_id' => $wawancaraId,
                        'umpan_balik' => $ub
                    ];
                }
            }
            if($validated['status_assesmen']) {
                foreach($validated['status_assesmen'] as $wawancaraId => $so) {
                    $arrStatusObservasi [] = [
                        'test_wawancara_id' => $wawancaraId,
                        'status_assesmen' => $so
                    ];
                }
            }

            for ($i=0; $i < count($validated['status_assesmen']); $i++) {
                $arrMerged [] = array_merge($arrTanggapan[$i], $arrUmpanBalik[$i], $arrStatusObservasi[$i]);
            }
            $arrResult = [
                'jawaban' => json_encode($arrMerged),
                'asesi_id' => $asesi['id'],
                'ttd_asesor' => $validated['ttd_asesor'],
                'tgl_ttd_asesor' => now(),
                'kelompok_asesor_id' => $kelompokAsesor['id']
            ];
            $result = UserTestWawancara::create($arrResult);
            if ($result) {
                DB::commit();
                return response()->json(['status' => 'success', 'code' => '200', 'message' => 'Data Test Wawancara berhasil ditambahkan'], 200);
            } else {
                DB::rollBack();
                return response()->json(['status' => 'error' ,'code' => '500', 'message' => 'Server Error 500'], 500);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    public function asesiSignature(Request $request)
    {
        $signatureAsesi = $request->input('signature');
        $asesiUuid = $request->asesi_id;
        $kelompokAsesorUuid = $request->kelompok_asesor;
        DB::beginTransaction();
        $asesi = Asesi::firstWhere('uuid',$asesiUuid);
        $kelompokAsesor = KelompokAsesor::firstWhere('uuid',$kelompokAsesorUuid);
        if(empty($asesi) || empty($kelompokAsesor)) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
        }

        $testWawancara = UserTestWawancara::firstWhere([
            ['asesi_id',$asesi['id']],
            ['kelompok_asesor_id',$kelompokAsesor['id']]
        ]);

        if($signatureAsesi) {
            if(!empty($testWawancara) && $testWawancara['ttd_asesi'] != null && Storage::exists($testWawancara['ttd_asesi'])) {
                Storage::delete($testWawancara['ttd_asesi']);
            }
            $imageName = time() . '.png';
            $path = public_path('storage/asesi_signatureTestWawancara/' . $imageName);
            $signatureAsesi = str_replace('data:image/png;base64,', '', $signatureAsesi);
            $signatureAsesi = str_replace(' ', '+', $signatureAsesi);
            file_put_contents($path, base64_decode($signatureAsesi));
            $resultTtdAsesi = 'asesi_signatureTestWawancara/'.$imageName;
        } else {
            $resultTtdAsesi = $testWawancara['ttd_asesi'];
        }

        $result = $testWawancara->update([
            'tgl_ttd_asesi' => now(),
            'ttd_asesi' => $resultTtdAsesi
        ]);
        if ($result) {
            DB::commit();
            return response()->json(['status' => 'success', 'code' => '200', 'message' => 'Data Test Wawancara berhasil ditandatangani'], 200);
        } else {
            DB::rollBack();
            return response()->json(['status' => 'error' ,'code' => '500', 'message' => 'Server Error 500'], 500);
        }
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
            $asesiId = Asesi::firstWhere('uuid', request('asesi_id'))->pluck('id');
        }

        $data = UserTestWawancara::firstWhere([
            ['asesi_id', $asesiId],
            ['kelompok_asesor_id', $kelompokAsesor['id']]
        ]);
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
}
