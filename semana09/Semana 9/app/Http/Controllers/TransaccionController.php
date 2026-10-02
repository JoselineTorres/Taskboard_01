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
        // Fusionamos los datos del formulario con un valor por defecto para metodo_pago
        $datos = array_merge($request->only([
            'comercio_id', 'cliente_nombre', 'monto',
        ]), [
            'metodo_pago' => 'Tarjeta', // Asignamos un método por defecto
        ]);

        $transaccion = Transaccion::create($datos);

        return redirect()
            ->route('comercios.show', $transaccion->comercio_id)
            ->with('mensaje', 'Transacción registrada con éxito.');
    }
}