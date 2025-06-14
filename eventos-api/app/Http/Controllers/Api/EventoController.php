<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Http\Resources\EventoResource;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index(Request $request)
    {
        $eventos = Evento::paginate(10);
        return EventoResource::collection($eventos);
    }
}
