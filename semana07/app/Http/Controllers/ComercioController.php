<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use Illuminate\Http\Request;

class ComercioController extends Controller
{
    // Guía Semana 7 (Blade): listado con conteo de transacciones
    public function index()
    {
        $comercios = Comercio::withCount('transacciones')->get();

        return view('comercios.index', compact('comercios'));
    }

    // Route Model Binding + load() para evitar el problema N+1
    public function show(Comercio $comercio)
    {
        $comercio->load('transacciones');

        return view('comercios.show', compact('comercio'));
    }
}
