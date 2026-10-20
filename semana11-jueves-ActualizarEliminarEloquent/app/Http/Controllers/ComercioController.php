<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ComercioController extends Controller
{
    public function index(Request $request): View
    {
        $comercios = Comercio::when($request->buscar, function ($query) use ($request) {
                return $query->where('nombre_comercio', 'like', "%{$request->buscar}%");
            })
            ->when($request->rubro, function ($query) use ($request) {
                return $query->where('rubro', $request->rubro);
            })
            ->withCount('transacciones')
            ->orderBy('nombre_comercio')
            ->get();

        return view('comercios.index', compact('comercios'));
    }

    public function show(Comercio $comercio): View
    {
        return view('comercios.show', compact('comercio'));
    }
}