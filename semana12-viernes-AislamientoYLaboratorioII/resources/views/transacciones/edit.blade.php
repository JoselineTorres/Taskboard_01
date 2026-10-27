@extends('layouts.app')

@section('titulo', 'Editar transacción')

@section('contenido')
<div class="container">
    <h2>Editar Transacción</h2>

    <form action="{{ route('transacciones.update', $transaccion) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="comercio_id" class="form-label">Comercio</label>
            <select id="comercio_id" name="comercio_id" class="form-control">
                @foreach ($comercios as $c)
                    <option value="{{ $c->id }}"
                        {{ old('comercio_id', $transaccion->comercio_id) == $c->id ? 'selected' : '' }}>
                        {{ $c->nombre_comercio }}
                    </option>
                @endforeach
            </select>
            @error('comercio_id')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="cliente" class="form-label">Cliente</label>
            <input id="cliente" name="cliente_nombre" type="text" class="form-control"
                   value="{{ old('cliente_nombre', $transaccion->cliente_nombre) }}">
            @error('cliente_nombre')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="monto" class="form-label">Monto ($)</label>
            <input id="monto" name="monto" type="number" step="0.01" class="form-control"
                   value="{{ old('monto', $transaccion->monto) }}">
            @error('monto')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="{{ route('comercios.show', $transaccion->comercio_id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection