<?php

namespace App\Http\Controllers;

use App\Models\Skema;
use App\Http\Requests\StoreSkemaRequest;
use App\Http\Requests\UpdateSkemaRequest;
use App\Models\UnitKompetensi;

class SkemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.skema.index');
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
    public function store(StoreSkemaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Skema $skema)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skema $skema)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSkemaRequest $request, Skema $skema)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        Skema::where('uuid', $uuid)->delete();
        return response()->json(['status' => 'success','message' => 'Skema berhasil dihapus'], 200);

    }

    public function datatable()
    {
        $data = Skema::latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function list_unitKompetensi($uuid)
    {
        $skmeId = Skema::where('uuid',$uuid)->pluck('id');
        if(isset($skmeId)) {
            $result = UnitKompetensi::where('skema_id', $skmeId)->get();
            return response()->json(['status' => 'success', 'data' => $result], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => 'Data skema tidak ditemukan'], 404);
        }
    }
}
