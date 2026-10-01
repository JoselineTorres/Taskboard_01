<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use Illuminate\Http\Request;

class ComercioController extends Controller
{
    // Guía N.º 2, Semana 6 (Viernes): datos reales con eager loading
    public function index()
    {
        return Comercio::with('transacciones')->get();
    }

    // Route Model Binding
    public function show(Comercio $comercio)
    {
        return $comercio->load('transacciones');
    }
}
