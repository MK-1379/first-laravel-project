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
        // 1. Validamos la descripción del tipo de evento
        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255',
        ]);

        // 2. Si algo falla, devolvemos los errores
        if ($validator->fails()) {
            return response()->json(['message' => 'Failed', 'data' => $validator->messages()], 400);
        }

        // 3. Guardamos el tipo de evento en la base de datos
        $eventType = EventType::create($validator->validated());

        // 4. Devolvemos el tipo de evento creado
        return response()->json(['message' => 'Event Type Created', 'data' => $eventType], 200);
    }
}
