<?php

namespace App\Http\Controllers;

use App\Models\FRAPL01;
use Illuminate\Http\Request;
use App\Models\KelompokAsesor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreFRAPL01Request;
use App\Http\Requests\UpdateFRAPL01Request;

class FRAPL01Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fullQueryString = request()->getQueryString();
        $uuid = request()->query->keys()[0];

        $query = KelompokAsesor::with(['skema','event','kelas','asesor.user']);
        $kelompokAsesorNotIn = (clone $query)->where('uuid','!=',$uuid)->get();
        $kelompokAsesor = $query->firstWhere('uuid',$uuid);
        return view('dashboard.frapl.frapl01.index',compact('kelompokAsesor','kelompokAsesorNotIn'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
        $validator = Validator::make($request->all(), [
            'signatureAsesi' => ['nullable'],
            'berkasFilePemohon.*' => ['required'],
            'statusBerkasPemohon.*' => ['required'],
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

        $data = [];
            // Memasukkan Keterangan Prasyarat
            if (isset($validated['statusBerkasPemohon']) && isset($validated['berkasFilePemohon'])) :
                foreach ($validated['statusBerkasPemohon'] as $key => $keterangan) {
                    // Memasukkan Berkas
                    foreach ($validated['berkasFilePemohon'][$key] as $b) {
                        $path = $b->store('berkas_rpapl01');
                        $data[$key] = [
                            'keterangan' => $keterangan[0],
                            'berkas' => $path
                        ];
                        break; // Hanya memproses satu berkas untuk setiap keterangan
                    }
                }
                $data = json_encode($data);
            endif;
        $validated['asesi_id'] = Auth::user()->asesi['id'];
    }

    /**
     * Display the specified resource.
     */
    public function show(FRAPL01 $fRAPL01)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FRAPL01 $fRAPL01)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFRAPL01Request $request, FRAPL01 $fRAPL01)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FRAPL01 $fRAPL01)
    {
        //
    }
}
