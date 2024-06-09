<?php

namespace App\Http\Controllers;

use App\Models\Asesi;
use App\Models\Asesor;
use App\Models\PersetujuanKerahasiaan;
use App\Http\Requests\StorePersetujuanKerahasiaanRequest;
use App\Http\Requests\UpdatePersetujuanKerahasiaanRequest;

class PersetujuanKerahasiaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersetujuanKerahasiaanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PersetujuanKerahasiaan $persetujuanKerahasiaan)
    {
        //
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
