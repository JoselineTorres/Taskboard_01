<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComercioResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'     => $this->id,
            'nombre' => $this->nombre_comercio,
            'rubro'  => $this->rubro,
            // Solo aparece si el comercio se cargó con load() o with()
            'transacciones' => TransaccionResource::collection(
                $this->whenLoaded('transacciones')
            ),
        ];
    }
}
