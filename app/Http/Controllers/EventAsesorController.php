<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Asesi;
use App\Models\KelompokAsesor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
        $data = $kelompokAsesor;
        // $data = $kelompokAsesor->kelas->asesi;

        // dd($data);
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function updateQualificationStatus(Request $request, $uuid)
    {
        // Debug untuk melihat isi request
        dd($request->all());

        // Validasi input
        $request->validate([
            'kelompok_asesor_id' => 'required|exists:t_kelompok_asesor,id',
            'new_status' => 'required|in:Kompeten,Belum Kompeten',
        ]);

        // Temukan kelompok asesor berdasarkan ID
        $kelompokAsesor = Asesi::findOrFail($request->input('kelompok_asesor_id'));

        // Update status
        $kelompokAsesor->is_qualification = $request->input('new_status');
        $kelompokAsesor->save();

        // Kembalikan respons sukses
        return response()->json(['status' => 'success', 'message' => 'Status berhasil diperbarui'], 200);
    }


}
