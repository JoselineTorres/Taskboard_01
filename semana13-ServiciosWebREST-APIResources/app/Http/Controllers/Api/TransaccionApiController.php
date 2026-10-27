<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuardarTransaccionRequest;
use App\Http\Resources\TransaccionResource;
use App\Models\Transaccion;
use Illuminate\Http\Request;

class TransaccionApiController extends Controller
{
    // GET /api/transacciones  (opcional: ?estado=Completada)
    public function index(Request $request)
    {
        $estado = $request->query('estado');

        return TransaccionResource::collection(
            Transaccion::when($estado, fn ($q) => $q->where('estado', $estado))
                ->latest()
                ->get()
        );
    }

    // GET /api/transacciones/{transaccion}
    public function show(Transaccion $transaccion)
    {
        return new TransaccionResource($transaccion);
    }

    // POST /api/transacciones  -> 201
    public function store(GuardarTransaccionRequest $request)
    {
        $datos = $request->validated();
        $datos['metodo_pago'] = 'Tarjeta'; // igual que en el store web

        $transaccion = Transaccion::create($datos)->refresh();

        return (new TransaccionResource($transaccion))
            ->response()
            ->setStatusCode(201);
    }

    // No se usa hoy; apiResource registra la ruta PUT/PATCH
    public function update(Request $request, Transaccion $transaccion)
    {
        //
    }

    // DELETE /api/transacciones/{transaccion}  -> 204
    public function destroy(Transaccion $transaccion)
    {
        $transaccion->delete();

        return response()->noContent();
    }
}