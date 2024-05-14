<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Skema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.event.index');
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
        $validator = Validator::make($request->all(), [
            'nama_event' => ['required', 'string', 'max:255', 'unique:m_event,nama_event'],
            'tuk' => ['required','in:Sewaktu,Tempat Kerja,Mandiri','string','max:200','min:5'],
            'event_mulai' => ['required','date'],
            'event_selesai' => ['required','date'],
            'keterangan' => ['required', 'string', 'max:255','min:5']
        ], $this->messageValidation());

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 422);
        }
        $validated = $validator->validated();
        $data =  Event::create($validated);
        if ($data) {
            return response()->json(['status' => 'success', 'message' => 'Data event berhasil ditambahkan'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Server Error 500'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        Event::where('uuid', $uuid)->delete();
        return response()->json(['status' => 'success','message' => 'Event berhasil dihapus'], 200);
    }

    public function datatable()
    {
        $data = Event::latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function list_skema($uuid)
    {
        $eventId = Event::where('uuid',$uuid)->pluck('id');
        if(isset($eventId)) {
            $result = Skema::where('event_id',$eventId)->get();
            return response()->json(['status' => 'success', 'data' => $result], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => 'Data event tidak ditemukan'], 404);
        }
    }
}
