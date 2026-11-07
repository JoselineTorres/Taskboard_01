<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comercio extends Model
{
    protected $fillable = ['user_id', 'nombre_comercio', 'rubro', 'fecha_afiliacion'];

    public function transacciones()
    {
        return $this->hasMany(Transaccion::class);
    }

    // Un comercio pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}