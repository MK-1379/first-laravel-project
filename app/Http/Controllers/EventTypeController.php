<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\EventType;
use Illuminate\Support\Facades\Validator;

class EventTypeController extends Controller
{
    public function listEvents(EventType $type){
        $events = $type->events;
        return response()->json(['message'=>'Eventos listados','data'=>$events],200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Failed', 'data' => $validator->messages()], 400);
        }

        $eventType = EventType::create($validator->validated());

        return response()->json(['message' => 'Event Type Created', 'data' => $eventType], 200);
    }
}
