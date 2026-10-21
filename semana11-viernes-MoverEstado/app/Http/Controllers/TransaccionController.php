<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use App\Models\Transaccion;
use App\Http\Requests\GuardarTransaccionRequest; // <-- 1. Importante agregar este use
use Illuminate\View\View;

class TransaccionController extends Controller
{
    public function create(Comercio $comercio): View
    {
        return view('transacciones.create', compact('comercio'));
    }

    // 2. Cambiamos (Request $request) por (GuardarTransaccionRequest $request)
    public function store(GuardarTransaccionRequest $request)
    {
        // Usamos $request->validated() para obtener los datos limpios
        $datosValidados = $request->validated();

        // Asignamos el método de pago por defecto
        $datosValidados['metodo_pago'] = 'Tarjeta';

        // Creamos la transacción
        $transaccion = Transaccion::create($datosValidados);

        return redirect()
            ->route('comercios.show', $transaccion->comercio_id)
            ->with('mensaje', 'Transacción registrada con éxito.');
    }
    public function edit(Transaccion $transaccion): View
    {
    $comercios = Comercio::orderBy('nombre_comercio')->get();

    return view('transacciones.edit', compact('transaccion', 'comercios'));
    }

public function update(GuardarTransaccionRequest $request, Transaccion $transaccion)
    {
    $transaccion->update($request->validated());

    return redirect()
        ->route('comercios.show', $transaccion->comercio_id)
        ->with('mensaje', 'Transacción actualizada correctamente.');
    }

public function destroy(Transaccion $transaccion)
    {
    // Se guardan los datos ANTES de borrar
    $comercioId = $transaccion->comercio_id;
    $cliente    = $transaccion->cliente_nombre;

    $transaccion->delete();

    return redirect()
        ->route('comercios.show', $comercioId)
        ->with('mensaje', "Transacción de {$cliente} eliminada.");
    }
   public function moverEstado(Transaccion $transaccion, string $estado)
    {
    $validos = ['Iniciada', 'Completada', 'Fallida'];

    if (!in_array($estado, $validos)) {
        abort(400, 'Estado no válido.');
    }

    // Mapa de transiciones permitidas desde cada estado
    $transiciones = [
        'Iniciada'   => ['Completada', 'Fallida'],
        'Completada' => [],
        'Fallida'    => ['Iniciada'],
    ];

    if (!in_array($estado, $transiciones[$transaccion->estado] ?? [])) {
        abort(400, "No se puede mover de {$transaccion->estado} a {$estado}.");
    }

    $transaccion->update(['estado' => $estado]);

    return redirect()
        ->route('comercios.show', $transaccion->comercio_id)
        ->with('mensaje', "Transacción movida a {$estado}.");
    }
    // Laboratorio 8: Reto de reutilización
    public function duplicarUltima(GuardarTransaccionRequest $request)
    {
        dd($request->validated());
    }


}