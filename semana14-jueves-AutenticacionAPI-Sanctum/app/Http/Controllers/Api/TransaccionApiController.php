<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuardarTransaccionRequest;
use App\Http\Resources\TransaccionResource;
use App\Models\Transaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaccionApiController extends Controller
{
    // GET /api/transacciones  (opcional: ?estado=Completada)
    public function index(Request $request)
    {
        $estado = $request->query('estado');

        $transacciones = Transaccion::whereHas('comercio', fn ($q) =>
                $q->where('user_id', $request->user()->id))
            ->when($estado, fn ($q) => $q->where('estado', $estado))
            ->latest()
            ->get();

        return TransaccionResource::collection($transacciones);
    }

    // Una transacción es del usuario si su comercio lo es; si no, 404
   private function autorizar(Transaccion $t): void
    {
    abort_unless($t->comercio->user_id === Auth::id(), 404);
    }

    // GET /api/transacciones/{transaccion}
    public function show(Transaccion $transaccion)
    {
        $this->autorizar($transaccion);

        return new TransaccionResource($transaccion);
    }

    // POST /api/transacciones -> 201
    // El Form Request valida que comercio_id sea del usuario del token (422 si no)
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
        $this->autorizar($transaccion);
    }

    // DELETE /api/transacciones/{transaccion} -> 204
    public function destroy(Transaccion $transaccion)
    {
        $this->autorizar($transaccion);

        $transaccion->delete();

        return response()->noContent();
    }
}