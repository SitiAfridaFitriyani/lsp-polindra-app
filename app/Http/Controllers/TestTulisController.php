<?php

namespace App\Http\Controllers;

use App\Models\KriteriaUnjukKerja;
use App\Models\TestTulis;
use Illuminate\Http\Request;

class TestTulisController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TestTulis $testTulis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TestTulis $testTulis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TestTulis $testTulis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $testTulis = TestTulis::where('uuid', $uuid);
        if(empty($testTulis->first())) {
            return response()->json(['status' => 'error', 'message' => 'Data test tidak ditemukan'], 404);
        }
        if($testTulis->delete()) {
            return response()->json(['status' => 'success','message' => 'Data test berhasil dihapus'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data test gagal dihapus'], 500);
        }
    }

    public function datatable()
    {
        $data = TestTulis::with('userTestTulis')->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function list()
    {
        $data = TestTulis::with('userTestTulis')->latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function listByUUID($uuid)
    {
        $kriteriaUnjukKerjaId = KriteriaUnjukKerja::with(['testTulis','elemen'])
            ->where('uuid',$uuid)
            ->pluck('id');
        if(isset($kriteriaUnjukKerjaId)) {
            $result = TestTulis::with('userTestTulis')
            ->where('kriteria_unjuk_kerja_id', $kriteriaUnjukKerjaId)
            ->latest()
            ->get();
            return response()->json(['status' => 'success', 'data' => $result, 'totalRecord' => count($result)], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => 'Data kriteria unjuk kerja tidak ditemukan'], 404);
        }
    }
}
