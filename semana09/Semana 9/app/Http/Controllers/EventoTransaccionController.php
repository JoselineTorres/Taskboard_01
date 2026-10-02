<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventoTransaccion; // Agregado - Guía N.º 2, Semana 6 (Viernes)

class EventoTransaccionController extends Controller
{
    public function index()
    {
        // Actualizado a datos reales - Guía N.º 2, Semana 6 (Viernes)
        return EventoTransaccion::with('transaccion.comercio')->get();
    }
}