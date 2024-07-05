<?php

namespace App\Http\Controllers;

use App\Models\Asesi;
use App\Models\Asesor;
use Illuminate\Http\Request;
use App\Models\KelompokAsesor;
use Illuminate\Support\Facades\Auth;
use App\Models\PersetujuanKerahasiaan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdatePersetujuanKerahasiaanRequest;

class PersetujuanKerahasiaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fullQueryString = request()->getQueryString();
        $uuid = request()->query->keys()[0];
        $kelompokAsesor = KelompokAsesor::with(['skema','event','kelas','asesor.user'])->firstWhere('uuid',$uuid);

        return view('dashboard.lembarPersetujuanAsesi.index',compact('kelompokAsesor'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'signatureAsesi' => ['nullable'],
            'berkas.*' => ['required'],
            'uuid' => ['required', 'exists:t_kelompok_asesor,uuid']
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages(), 'errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();
        $kelompokAsesor = KelompokAsesor::firstWhere('uuid', $validated['uuid']);
        if(empty($kelompokAsesor)) {
            return response()->json(['status' => 'error', 'message' => 'Data kelompok asesor tidak ditemukan'], 404);
        }

        $berkas = [];
        foreach ($validated['berkas'] as $val) {
            $berkas[] = $val;
        }
        $validated['berkas'] = json_encode($berkas);
        $validated['asesi_id'] = Auth::user()->asesi['id'];
        $validated['tgl_ttd_asesi'] = now();

        $existingData = PersetujuanKerahasiaan::firstWhere([
            'asesi_id' => Auth::user()->asesi['id'],
            'kelompok_asesor_id' => $kelompokAsesor['id']
        ]);
        // TTD Asesi
        $signatureAsesi = $request->input('signatureAsesi');
        if($signatureAsesi) {
            if(!empty($existingData) && $existingData['ttd_asesi'] != null && Storage::exists($existingData['ttd_asesi'])) {
                Storage::delete($existingData['ttd_asesi']);
            }
            $imageName = time() . '.png';
            $path = public_path('storage/asesi_signaturePersetujuanKerahasiaan/' . $imageName);
            $signatureAsesi = str_replace('data:image/png;base64,', '', $signatureAsesi);
            $signatureAsesi = str_replace(' ', '+', $signatureAsesi);
            file_put_contents($path, base64_decode($signatureAsesi));
            $validated['ttd_asesi'] = 'asesi_signaturePersetujuanKerahasiaan/'.$imageName;
        } else {
            $validated['ttd_asesi'] = $existingData['ttd_asesi'];
        }

        $data =  PersetujuanKerahasiaan::updateOrCreate([
                'asesi_id' => Auth::user()->asesi['id'],
                'kelompok_asesor_id' => $kelompokAsesor['id']
            ],
            [
                'berkas' => $validated['berkas'],
                'ttd_asesi' => $validated['ttd_asesi'],
                'tgl_ttd_asesi' => $validated['tgl_ttd_asesi']
            ]);
        if ($data) {
            return response()->json(['status' => 'success', 'message' => 'Data persetujuan assesmen berhasil ditambahkan'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    public function showByKelompokAsesor()
    {
        $kelompokAsesorUuid = request('kelompok_asesor');

        $kelompokAsesor = KelompokAsesor::firstWhere('uuid', $kelompokAsesorUuid);

        $data = PersetujuanKerahasiaan::firstWhere([
            'asesi_id' => Auth::user()->asesi['id'],
            'kelompok_asesor_id' => $kelompokAsesor['id']
        ]);
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersetujuanKerahasiaan $persetujuanKerahasiaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersetujuanKerahasiaanRequest $request, PersetujuanKerahasiaan $persetujuanKerahasiaan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersetujuanKerahasiaan $persetujuanKerahasiaan)
    {
        //
    }

    public function datatable()
    {
        $data = PersetujuanKerahasiaan::with(['asesor','asesi','skema'])->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function list()
    {
        $data = PersetujuanKerahasiaan::with(['asesor','asesi','skema'])->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function listByAsesorUUID($uuid)
    {
        $asesorId = Asesor::with('user')
            ->where('uuid',$uuid)
            ->pluck('id');
        if(isset($asesorId)) {
            $result = PersetujuanKerahasiaan::with(['asesor','asesi.user.name','skema'])
            ->where('asesor_id', $asesorId)
            ->latest()
            ->get();
            return response()->json(['status' => 'success', 'data' => $result, 'totalRecord' => count($result)], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => 'Data asesor tidak ditemukan'], 404);
        }
    }

    public function listByAsesiUUID($uuid)
    {
        $asesiId = Asesi::with('user')
            ->where('uuid',$uuid)
            ->pluck('id');
        if(isset($asesiId)) {
            $result = PersetujuanKerahasiaan::with(['asesor.user.name','asesi','skema'])
            ->where('asesi_id', $asesiId)
            ->latest()
            ->get();
            return response()->json(['status' => 'success', 'data' => $result, 'totalRecord' => count($result)], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => 'Data asesi tidak ditemukan'], 404);
        }
    }
}
