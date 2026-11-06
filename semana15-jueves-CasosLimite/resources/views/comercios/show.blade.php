
@extends('layouts.app')

@section('titulo', $comercio->nombre_comercio)

@section('contenido')
    <p>
        <a href="{{ route('comercios.index') }}">
            &larr; Volver a comercios
        </a>
    </p>

    <h1>{{ $comercio->nombre_comercio }}</h1>

    {{-- Enlace para registrar una nueva transacción (Laboratorio 5) --}}
    <p>
        <a href="{{ route('transacciones.create', $comercio) }}">
            + Nueva transacción
        </a>
    </p>

    <p class="meta">
        Rubro: {{ $comercio->rubro }}
        &middot;
        Teléfono: {{ $comercio->telefono ?? 'Sin teléfono registrado' }}
    </p>

    {{-- Resumen de actividad --}}
    @if ($comercio->transacciones->count() === 0)
        <p class="meta">
            Este comercio es nuevo, aún no registra actividad.
        </p>
    @elseif ($comercio->transacciones->count() === 1)
        <p class="meta">
            Este comercio tiene su primera transacción registrada.
        </p>
    @else
        <p class="meta">
            Este comercio tiene un historial de
            {{ $comercio->transacciones->count() }} transacciones.
        </p>
    @endif

    <h2>Transacciones</h2>

    @forelse ($comercio->transacciones as $transaccion)
        <div class="card">
            <strong>${{ number_format($transaccion->monto, 2) }}</strong>
            — {{ $transaccion->cliente_nombre }}

            <x-badge-estado :estado="$transaccion->estado" />

            <div style="margin-top: 0.5rem;">
                {{-- Editar transacción --}}
                <a href="{{ route('transacciones.edit', $transaccion) }}">
                    Editar
                </a>

                {{-- Eliminar transacción --}}
                <form
                    action="{{ route('transacciones.destroy', $transaccion) }}"
                    method="POST"
                    style="display: inline;"
                    onsubmit="return confirm('¿Eliminar esta transacción? Esta acción no se puede deshacer.')"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit">Eliminar</button>
                </form>

                {{-- Semana 11 (viernes): botones de estado, solo para Iniciada --}}
               @if($transaccion->estado === 'Iniciada')
                    {{-- Marcar como completada --}}
                    <form
                        action="{{ route('transacciones.mover', [$transaccion, 'Completada']) }}"
                        method="POST"
                        style="display: inline;"
                    >
                        @csrf
                        @method('PATCH')

                        <button type="submit">
                            Marcar Completada
                        </button>
                    </form>

                    {{-- Marcar como fallida --}}
                    <form
                        action="{{ route('transacciones.mover', [$transaccion, 'Fallida']) }}"
                        method="POST"
                        style="display: inline;"
                    >
                        @csrf
                        @method('PATCH')

                        <button type="submit">
                            Marcar Fallida
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <p>Sin transacciones</p>
    @endforelse
@endsection
