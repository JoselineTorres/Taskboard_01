<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\TransaccionApiController;
use App\Http\Resources\ComercioResource;
use App\Models\Comercio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Ruta PÚBLICA: 5 intentos por minuto
Route::post('/login', [AuthApiController::class, 'login'])
    ->middleware('throttle:5,1');

// Todo lo demás exige un token válido (sin token: 401)
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/yo', [AuthApiController::class, 'yo']);
    Route::post('/logout', [AuthApiController::class, 'logout']);

    // RETO (opcional)
    Route::get('/tokens', [AuthApiController::class, 'tokens']);
    Route::delete('/tokens/{id}', [AuthApiController::class, 'cerrarDispositivo']);

    // Solo los comercios del dueño del token
    Route::get('/comercios', function (Request $request) {
        return ComercioResource::collection(
            Comercio::query()->orderBy('nombre_comercio')->get()
        );
    });

    // Un comercio ajeno responde 404 (no revela que existe)
    Route::get('/comercios/{comercio}', function (Request $request, Comercio $comercio) {
        abort_unless($comercio->user_id === $request->user()->id, 404);

        return new ComercioResource($comercio->load('transacciones'));
    });

    Route::apiResource('transacciones', TransaccionApiController::class)
        ->parameters(['transacciones' => 'transaccion'])
        ->names('api.transacciones');
});