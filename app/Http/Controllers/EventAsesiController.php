<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\KelompokAsesor;
use Illuminate\Support\Facades\Auth;

class EventAsesiController extends Controller
{
    public function show($uuid)
    {
        $kelas_id = Auth::user()->asesi['kelas_id'];
        $current_time = Carbon::now();
        $query = KelompokAsesor::query();
        $singleDataKelompokAsesor = (clone $query)->with('event')->firstWhere('uuid',$uuid)->event['nama_event'];
        $kelompokAsesor = $query->where([['kelas_id', $kelas_id],['uuid','!=',$uuid]])
            ->whereHas('event', function($query) use ($current_time) {
                $query->where('event_mulai', '<=', $current_time)
                    ->where('event_selesai', '>=', $current_time);
            })
            ->with(['event' => function($query) use ($current_time) {
                $query->where('event_mulai', '<=', $current_time)
                    ->where('event_selesai', '>=', $current_time);
            }])
            ->get();
        return view('dashboard.eventAsesi.index',compact('kelompokAsesor','singleDataKelompokAsesor'));
    }

    public function datatable($uuid)
    {
        $data = KelompokAsesor::with(['skema','event','kelas','asesor.user'])->where('uuid',$uuid)->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
}
