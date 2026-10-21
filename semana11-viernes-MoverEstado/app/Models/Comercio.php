<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comercio extends Model
{
    protected $fillable = ['nombre_comercio', 'rubro', 'fecha_afiliacion'];
    
    public function transacciones()
{
    return $this->hasMany(Transaccion::class);
}
}
