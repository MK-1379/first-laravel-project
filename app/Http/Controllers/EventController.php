<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{

    public function index()
    {
        $events = Event::all();
        return response()->json(['message' => 'Eventos totales', 'data' => $events], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_name'   => 'required|string|max:255',
            'event_detail' => 'nullable|string|max:255',
            'event_type_id' => 'required|integer|exists:event_types,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Failed', 'data' => $validator->messages()], 400);
        }

        $event = Event::create($validator->validated());

        return response()->json(['message' => 'Event Created', 'data' => $event], 200);
    }

    public function show(string $id)
    {
        $event = Event::findOrFail($id);
        return response()->json(['message' => 'Event Updated', 'data' => $event], 200);
    }

    public function destroy(Request $request, string $id)
    {
        $event = Event::findOrFail($id);
        $res = $event->delete();

        if($res){
            return response()->json(['message' => 'Evento eliminado', 'data' => $event], 201);
        }
        return response()->json(['message' => 'Error eliminando el evento', 'data' => $event], 500);
    }

    public function listUsers(Event $event)
    {
        $users = $event->users;
        return response()->json(['message'=>null,'data'=>$users],200);
    }
}
