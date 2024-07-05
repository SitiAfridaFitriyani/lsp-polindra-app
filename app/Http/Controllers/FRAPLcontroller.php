<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KelompokAsesor;

class FRAPLcontroller extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $fullQueryString = request()->getQueryString();
        $uuid = request()->query->keys()[0];

        $query = KelompokAsesor::with(['skema','event','kelas','asesor.user']);
        $kelompokAsesorNotIn = (clone $query)->where('uuid','!=',$uuid)->get();
        $kelompokAsesor = $query->firstWhere('uuid',$uuid);

        return view('dashboard.frapl.index',compact('kelompokAsesor','kelompokAsesorNotIn'));

    }
}
