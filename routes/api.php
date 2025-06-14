<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventoController;

Route::middleware('auth:sanctum')->get('/eventos', [EventoController::class, 'index']);
