<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use App\Models\Transaccion;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransaccionController extends Controller
{
    public function create(Comercio $comercio): View
    {
        return view('transacciones.create', compact('comercio'));
    }

    public function store(Request $request)
    {
        // Validar la petición con la Misión A incluida
        $datosValidados = $request->validate([
            'comercio_id'    => 'required|exists:comercios,id',
            'cliente_nombre' => 'required|string|min:3|max:255', // <-- Regla min:3 agregada
            'monto'          => 'required|numeric|min:0.01',
        ], [
            'cliente_nombre.required' => 'Debes indicar el nombre del cliente.',
            'cliente_nombre.min'      => 'El nombre del cliente es demasiado corto.', // <-- Mensaje de la Misión A
            'monto.required'          => 'Debes indicar un monto.',
            'monto.numeric'           => 'El monto debe ser un número.',
            'monto.min'               => 'El monto debe ser mayor a cero.',
        ]);

        // Asignar el método de pago por defecto
        $datosValidados['metodo_pago'] = 'Tarjeta';

        // Crear la transacción
        $transaccion = Transaccion::create($datosValidados);

        return redirect()
            ->route('comercios.show', $transaccion->comercio_id)
            ->with('mensaje', 'Transacción registrada con éxito.');
    }
}