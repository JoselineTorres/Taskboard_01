@extends('layouts.app')

@section('contenido')
<div class="container">
    <h2>Nueva Transacción para {{ $comercio->nombre }}</h2>

    <form action="{{ route('transacciones.store') }}" method="POST">
        @csrf
        <input type="hidden" name="comercio_id" value="{{ $comercio->id }}">

        {{-- Campo Cliente --}}
        <div class="mb-3">
            <label for="cliente" class="form-label">Cliente</label>
            <input id="cliente" 
                   name="cliente_nombre" 
                   type="text" 
                   class="form-control"
                   value="{{ old('cliente_nombre') }}">
            @error('cliente_nombre')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>

        {{-- Campo Monto --}}
        <div class="mb-3">
            <label for="monto" class="form-label">Monto ($)</label>
            <input id="monto" 
                   name="monto" 
                   type="number" 
                   step="0.01" 
                   class="form-control"
                   value="{{ old('monto') }}">
            @error('monto')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Registrar Transacción</button>
        <a href="{{ route('comercios.show', $comercio->id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection