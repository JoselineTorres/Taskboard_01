<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComercioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaccionController;
use App\Http\Controllers\EventoTransaccionController;

/*
|--------------------------------------------------------------------------
| Rutas públicas (Semana 5 y prácticas): no requieren sesión
|--------------------------------------------------------------------------
*/

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

# Guía de la semana 9 día jueves
Route::get('/practica/formulario-demo', function () {
    return view('practica.formulario_demo');
});

Route::post('/practica/enviar', function () {
    return 'Formulario recibido correctamente.';
});

/*
|--------------------------------------------------------------------------
| Semana 12 (jueves): rutas para quien NO tiene sesión (registro y login)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro');
    Route::post('/registro', [AuthController::class, 'registrar'])->name('registro.store');
    Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

/*
|--------------------------------------------------------------------------
| Semana 12 (jueves): rutas protegidas, solo con sesión activa
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Comercios y transacciones
    Route::get('/transacciones', [TransaccionController::class, 'index']); # http://127.0.0.1:8000/transacciones

    Route::get('/transaccion/{transaccion}', [TransaccionController::class, 'show']); # http://127.0.0.1:8000/transaccion/1

    Route::get('/eventos-transaccion', [EventoTransaccionController::class, 'index']); # http://127.0.0.1:8000/eventos-transaccion

    Route::prefix('comercios')->name('comercios.')->group(function () {

        Route::get('/', [ComercioController::class, 'index'])
            ->name('index'); # http://127.0.0.1:8000/comercios

        Route::get('/{comercio}', [ComercioController::class, 'show'])
            ->name('show'); # http://127.0.0.1:8000/comercios/2

    });

    // Semana 9: crear transacciones
    Route::get('/comercios/{comercio}/transacciones/nueva', [TransaccionController::class, 'create'])
        ->name('transacciones.create');

    Route::post('/transacciones', [TransaccionController::class, 'store'])
        ->name('transacciones.store');

    Route::post('/transacciones/duplicar-prueba', [TransaccionController::class, 'duplicarUltima'])
        ->name('transacciones.duplicar');

    // Semana 11 (jueves): actualizar y eliminar
    Route::get('/transacciones/{transaccion}/editar', [TransaccionController::class, 'edit'])
        ->name('transacciones.edit');

    Route::put('/transacciones/{transaccion}', [TransaccionController::class, 'update'])
        ->name('transacciones.update');

    Route::delete('/transacciones/{transaccion}', [TransaccionController::class, 'destroy'])
        ->name('transacciones.destroy');

    // Semana 11 (viernes): mover estado
    Route::patch('/transacciones/{transaccion}/mover/{estado}', [TransaccionController::class, 'moverEstado'])
        ->name('transacciones.mover');

});