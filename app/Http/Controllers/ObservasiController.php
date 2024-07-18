<?php

namespace App\Http\Controllers;

use App\Models\{KelompokAsesor,Asesi,Observasi};
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreObservasiRequest;
use App\Http\Requests\UpdateObservasiRequest;

class ObservasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $uuid = request()->query->keys()[0];
        $query = KelompokAsesor::with(['skema.unitKompetensi.elemen','event','kelas','asesor.user']);

        if(Gate::allows('asesor')) {
            $asesi = Asesi::firstWhere('uuid',$uuid);
            $kelompokAsesorId = request('kelompok-asesor-id');
            $kelompokAsesorNotIn = (clone $query)->where('uuid','!=',$kelompokAsesorId)->get();
            $kelompokAsesor = $query->where([
                ['kelas_id',$asesi['kelas_id']],
                ['uuid', $kelompokAsesorId]
            ])->first();
        } elseif (Gate::allows('asesi')) {
            $kelompokAsesorNotIn = (clone $query)->where('uuid','!=',$uuid)->get();
            $kelompokAsesor = $query->firstWhere('uuid',$uuid);
        }
        return view('dashboard.checklistObservasiAsesi.index',compact('kelompokAsesor','kelompokAsesorNotIn'));

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
    public function store(StoreObservasiRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Observasi $observasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Observasi $observasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateObservasiRequest $request, Observasi $observasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Observasi $observasi)
    {
        //
    }
}
