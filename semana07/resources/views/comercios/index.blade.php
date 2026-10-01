@extends('layouts.app')

@section('titulo', 'Comercios afiliados')

@section('contenido')
    <h1>Comercios afiliados a la pasarela</h1>

    <ul class="comercios">
        @forelse ($comercios as $comercio)
            <li class="card">
                <a href="{{ route('comercios.show', $comercio) }}">
                    {{ $comercio->nombre_comercio }}
                </a>
                <span class="meta">— {{ $comercio->rubro }}
                    ({{ $comercio->transacciones_count ?? $comercio->transacciones->count() }} transacciones)</span>
                <br>
                <x-badge-actividad :totalTransacciones="$comercio->transacciones_count ?? $comercio->transacciones->count()" />
            </li>
        @empty
            <li class="card">Aún no hay comercios afiliados.</li>
        @endforelse
    </ul>
@endsection