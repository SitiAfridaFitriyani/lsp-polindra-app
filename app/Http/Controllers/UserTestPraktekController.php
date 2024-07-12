<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Storage,Validator,Auth,DB};
use App\Models\{UserTestPraktek,KelompokAsesor};

class UserTestPraktekController extends Controller
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

        return view('dashboard.testAssesmen.testPraktek.index',compact('kelompokAsesor','kelompokAsesorNotIn'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'signatureAsesi' => ['nullable'],
            'jawaban' => ['required'],
            'file' => ['nullable'],
            'kelompok-asesor-uuid' => ['required', 'exists:t_kelompok_asesor,uuid'],

        ], $this->messageValidation());

        $kelompokAsesor = KelompokAsesor::firstWhere('uuid', request('kelompok-asesor-uuid'));
        if(empty($kelompokAsesor)) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Data kelompok asesor tidak ditemukan'], 404);
        }

        $existingData = UserTestPraktek::firstWhere([
            ['asesi_id', Auth::user()->asesi['id']],
            ['kelompok_asesor_id', $kelompokAsesor['id']],
            ['test_praktek_id' , $kelompokAsesor->skema->testPraktek['id']]
        ]);

        if(empty($existingData)) {
            $request->validate([
                'signatureAsesi' => ['required'],
            ],$this->messageValidation());
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
                $path = public_path('storage/asesi_signatureTestPraktek/' . $imageName);
                $signatureAsesi = str_replace('data:image/png;base64,', '', $signatureAsesi);
                $signatureAsesi = str_replace(' ', '+', $signatureAsesi);
                file_put_contents($path, base64_decode($signatureAsesi));
                $validated['ttd_asesi'] = 'asesi_signatureTestPraktek/'.$imageName;
            } else {
                $validated['ttd_asesi'] = $existingData['ttd_asesi'];
            }

            if(isset($validated['file']) && !empty($existingData['file']) && count(json_decode($existingData['file'])) > 0) {
                $jcdBerkas = json_decode($existingData['file'],true);
                foreach($jcdBerkas as $berkas) {
                    Storage::delete($berkas);
                }
                $existingData->update(['file' => json_encode([])]);
            }

            $arrFileBerkas = [];
            if (isset($validated['file'])) :
                foreach ($validated['file'] as $b) {
                    $path = $b->store('berkas_testPraktek');
                    $arrFileBerkas[] = $path;
                }
            else:
                $jcdBerkas = json_decode($existingData['file'],true);
                $arrFileBerkas = $jcdBerkas;
            endif;

            $validated['file'] = json_encode($arrFileBerkas);
            $validated['asesi_id'] = Auth::user()->asesi['id'];
            $validated['tgl_ttd_asesi'] = now();

            $result = UserTestPraktek::updateOrCreate([
                    'asesi_id' => Auth::user()->asesi['id'],
                    'kelompok_asesor_id' => $kelompokAsesor['id'],
                    'test_praktek_id' => $kelompokAsesor->skema->testPraktek['id']
                ],
                [
                    'ttd_asesi' => $validated['ttd_asesi'],
                    'file' => $validated['file'],
                    'jawaban' => $validated['jawaban'],
                    'asesi_id' => $validated['asesi_id'],
                    'tgl_ttd_asesi' => $validated['tgl_ttd_asesi']
                ]);
            if ($result) {
                DB::commit();
                return response()->json(['status' => 'success', 'code' => '200', 'message' => 'Data Test Praktek berhasil ditambahkan'], 200);
            } else {
                DB::rollBack();
                return response()->json(['status' => 'error' ,'code' => '500', 'message' => 'Server Error 500'], 500);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error','code' => '500', 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(UserTestPraktek $userTestPraktek)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserTestPraktek $userTestPraktek)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserTestPraktek $userTestPraktek)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserTestPraktek $userTestPraktek)
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

        $data = UserTestPraktek::firstWhere([
            ['asesi_id', Auth::user()->asesi['id']],
            ['kelompok_asesor_id', $kelompokAsesor['id']]
        ]);
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
}
