<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransaccionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'comercio_id' => $this->comercio_id, // nuevo: lo usa el cliente web
            'cliente'     => $this->cliente_nombre,
            'monto'       => (float) $this->monto,
            'estado'      => $this->estado,
            'fecha'       => $this->created_at->toIso8601String(),
        ];
    }
}