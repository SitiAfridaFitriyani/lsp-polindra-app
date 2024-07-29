<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\KelompokAsesor;
use Illuminate\Support\Facades\Auth;

class EventAsesorController extends Controller
{
    public function show($uuid)
    {
        $asesor_id = Auth::user()->asesor['id'];
        $current_time = Carbon::now();
        $query = KelompokAsesor::query();
        $singleDataKelompokAsesor = (clone $query)->with('event')->firstWhere('uuid',$uuid)->event['nama_event'];
        $kelompokAsesor = $query->where([['asesor_id', $asesor_id],['uuid', '!=', $uuid]])
            ->whereHas('event', function($query) use ($current_time) {
                $query->where('event_mulai', '<=', $current_time)
                    ->where('event_selesai', '>=', $current_time);
            })
            ->with(['event' => function($query) use ($current_time) {
                $query->where('event_mulai', '<=', $current_time)
                    ->where('event_selesai', '>=', $current_time);
            }])
            ->get();
        return view('dashboard.eventAsesor.index',compact('kelompokAsesor','singleDataKelompokAsesor'));
    }

    public function datatable($uuid)
    {
        $asesor_id = Auth::user()->asesor['id'];
        $kelompokAsesor = KelompokAsesor::with(['skema','event','kelas.asesi.user','asesor.user'])->firstWhere([
            ['uuid',$uuid],
            ['asesor_id', $asesor_id]
        ]);
        $data = $kelompokAsesor->kelas->asesi;
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
}
