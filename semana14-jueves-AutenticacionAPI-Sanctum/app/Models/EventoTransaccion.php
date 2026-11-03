<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoTransaccion extends Model
{
    // Laravel adivinaría "evento_transaccions"; esta línea le dice el nombre real
    protected $table = 'eventos_transaccion';

    // Campos que se pueden llenar con create() o update()
    protected $fillable = ['transaccion_id', 'estado_anterior', 'estado_nuevo'];

    // Un evento pertenece a una transacción
    public function transaccion()
    {
        return $this->belongsTo(Transaccion::class);
    }
}