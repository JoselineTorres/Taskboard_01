@extends('layouts.app')

@section('titulo', 'Comercios afiliados')

@section('contenido')
    <h1>Comercios afiliados a la pasarela</h1>

    <form action="{{ route('comercios.index') }}" method="GET">
        {{-- Campo para búsqueda por nombre --}}
        <input type="text" name="buscar" 
               placeholder="Buscar comercio..." 
               value="{{ request('buscar') }}">

        {{-- Reto: Campo para filtrar por rubro --}}
        <select name="rubro">
            <option value="">-- Todos los rubros --</option>
            <option value="Restaurante" {{ request('rubro') == 'Restaurante' ? 'selected' : '' }}>Restaurante</option>
            <option value="Ferretería" {{ request('rubro') == 'Ferretería' ? 'selected' : '' }}>Ferretería</option>
            <option value="Supermercado" {{ request('rubro') == 'Supermercado' ? 'selected' : '' }}>Supermercado</option>
            <option value="Tecnología" {{ request('rubro') == 'Tecnología' ? 'selected' : '' }}>Tecnología</option>
        </select>

        <button type="submit">Buscar</button>
    </form>

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