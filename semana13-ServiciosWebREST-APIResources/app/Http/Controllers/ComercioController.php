<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ComercioController extends Controller
{
   public function index(Request $request): View
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    // Solo los comercios del usuario de la sesión
    $comercios = $user
        ->comercios()
        ->when($request->buscar, function ($query) use ($request) {
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
        // 404 si el comercio no es del usuario (no revela que existe)
        abort_unless($comercio->user_id === Auth::id(), 404);

        $comercio->load('transacciones');

        return view('comercios.show', compact('comercio'));
    }
}