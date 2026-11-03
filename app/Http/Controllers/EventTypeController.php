<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventType;

class EventTypeController extends Controller
{
    public function listEvents(EventType $type){
        $events = $type->events;
        return response()->json(['message'=>'Eventos listados','data'=>$events],200);
    }
}
