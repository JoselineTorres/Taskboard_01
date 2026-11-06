<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuardarTransaccionRequest;
use App\Models\Comercio;
use App\Models\Transaccion;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TransaccionController extends Controller
{
    // Semana 12 (viernes): una transacción es del usuario si su comercio lo es
    private function autorizar(Transaccion $transaccion): void
    {
        abort_unless($transaccion->comercio->user_id === Auth::id(), 404);
    }

    public function create(Comercio $comercio): View
    {
        // No se puede abrir el formulario de un comercio ajeno
        abort_unless($comercio->user_id === Auth::id(), 404);

        return view('transacciones.create', compact('comercio'));
    }

    public function store(GuardarTransaccionRequest $request)
    {
        $datosValidados = $request->validated();

        // Asignamos el método de pago por defecto
        $datosValidados['metodo_pago'] = 'Tarjeta';

        $transaccion = Transaccion::create($datosValidados);

        return redirect()
            ->route('comercios.show', $transaccion->comercio_id)
            ->with('mensaje', 'Transacción registrada con éxito.');
    }

    // Semana 11 (jueves)
    public function edit(Transaccion $transaccion): View
{
    $this->autorizar($transaccion);

    /** @var \App\Models\User $user */
    $user = Auth::user();

    $comercios = $user->comercios()->orderBy('nombre_comercio')->get();

    return view('transacciones.edit', compact('transaccion', 'comercios'));
}

    public function update(GuardarTransaccionRequest $request, Transaccion $transaccion)
    {
        $this->autorizar($transaccion);

        $transaccion->update($request->validated());

        return redirect()
            ->route('comercios.show', $transaccion->comercio_id)
            ->with('mensaje', 'Transacción actualizada correctamente.');
    }

    public function destroy(Transaccion $transaccion)
    {
        $this->autorizar($transaccion);

        // Se guardan los datos ANTES de borrar (Misión B)
        $comercioId = $transaccion->comercio_id;
        $cliente    = $transaccion->cliente_nombre;

        $transaccion->delete();

        return redirect()
            ->route('comercios.show', $comercioId)
            ->with('mensaje', "Transacción de {$cliente} eliminada.");
    }

    // Semana 11 (viernes)
    public function moverEstado(Transaccion $transaccion, string $estado)
    {
        $this->autorizar($transaccion);

        $validos = ['Iniciada', 'Completada', 'Fallida'];

        if (!in_array($estado, $validos)) {
            abort(400, 'Estado no válido.');
        }

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

    // Laboratorio 8 (Semana 9): reto de reutilización
    public function duplicarUltima(GuardarTransaccionRequest $request)
    {
        dd($request->validated());
    }
}