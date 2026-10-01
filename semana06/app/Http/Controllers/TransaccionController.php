<?php

namespace App\Http\Controllers;

use App\Models\Transaccion;
use Illuminate\Http\Request;

class TransaccionController extends Controller
{
    // Guía N.º 2, Semana 6 (Viernes): datos reales con eager loading
    public function index()
    {
        return Transaccion::with('comercio')->get();
    }

    // Route Model Binding
    public function show(Transaccion $transaccion)
    {
        return $transaccion->load('comercio');
    }
}
