<?php

use App\Http\Controllers\ComercioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaccionController;
use App\Http\Controllers\EventoTransaccionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/taskboard', function () {
    return 'Bienvenido a TaskBoard, tu pasarela de pagos.';
});

Route::get('/acerca-de', function () { # http://127.0.0.1:8000/acerca-de
    return 'TaskBoard es una pasarela de pagos que permite a comercios afiliados recibir pagos de sus clientes y dar seguimiento a cada transacción hasta su liquidación.';
});

Route::get('/contacto', function () { # http://127.0.0.1:8000/contacto
    return 'Joseline Abigail Torres Jurado TJ-64893';
});

Route::get('/comercios-lista', function () { # http://127.0.0.1:8000/comercios-lista
    return ['Mercado la Tiendona', 'Farmacia Camila', 'Spotify'];
});

Route::get('/comercio/{nombre}', function ($nombre) { # http://127.0.0.1:8000/comercio/PupuseriaElSalvador
    return "¡Bienvenido a TaskBoard, $nombre!";
});

Route::get('/estados', function () { # http://127.0.0.1:8000/estados
    return ['Iniciada', 'Procesando', 'Aprobada', 'Rechazada', 'Liquidada'];
});

Route::get('/transaccion/demo', function () { # http://127.0.0.1:8000/transaccion/demo
    return [
        'id' => 1,
        'comercio' => 'Tiendona',
        'monto' => 20.00,
        'moneda' => 'USD',
        'estado' => 'Aprobada',
    ];
});

Route::get('/transacciones', [TransaccionController::class, 'index']); # http://127.0.0.1:8000/transacciones

Route::get('/transaccion/{transaccion}', [TransaccionController::class, 'show']); #http://127.0.0.1:8000/transaccion/1

Route::get('/eventos-transaccion', [EventoTransaccionController::class, 'index']); # http://127.0.0.1:8000/eventos-transaccion

Route::prefix('comercios')->name('comercios.')->group(function () {

    Route::get('/', [ComercioController::class, 'index'])
        ->name('index'); # http://127.0.0.1:8000/comercios

    Route::get('/{comercio}', [ComercioController::class, 'show'])
        ->name('show'); # http://127.0.0.1:8000/comercios/2

});
