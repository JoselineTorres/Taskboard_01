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
    
    // Laboratorio 8: Reto de reutilización
    public function duplicarUltima(GuardarTransaccionRequest $request)
    {
        dd($request->validated());
    }


}