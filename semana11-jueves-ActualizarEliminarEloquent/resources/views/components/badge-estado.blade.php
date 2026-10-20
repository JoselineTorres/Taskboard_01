{{-- Uso: <x-badge-estado :estado="$transaccion->estado" /> --}}
@props(['estado'])

@if ($estado === 'Aprobada' || $estado === 'Liquidada')
    <span class="badge verde">✔ {{ $estado }}</span>
@elseif ($estado === 'Rechazada')
    <span class="badge rojo">✗ Rechazada</span>
@else
    <span class="badge amarillo">⏳ {{ $estado }}</span>
@endif