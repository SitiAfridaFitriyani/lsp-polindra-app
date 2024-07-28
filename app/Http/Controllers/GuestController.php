<?php

namespace App\Http\Controllers;

use App\Models\Skema;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        $skema = Skema::latest()->limit(3)->get();
        return view('guest.index',compact('skema'));
    }

    public function registerAssesmen($uuid)
    {
        $skema = Skema::firstWhere('uuid',$uuid);
        if(empty($skema)) {
            return back()->with('error','Data skema tidak ditemukan');
        }
        return view('guest.registerAssesmen.index',compact('skema'));
    }
}
