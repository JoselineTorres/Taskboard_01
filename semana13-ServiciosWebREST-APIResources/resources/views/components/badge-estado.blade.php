
{{-- Uso: <x-badge-estado :estado="$transaccion->estado" /> --}}
@props(['estado'])

@if (in_array($estado, ['Aprobada', 'Liquidada', 'Completada']))
    <span class="badge verde">✔ {{ $estado }}</span>
@elseif (in_array($estado, ['Rechazada', 'Fallida']))
    <span class="badge rojo">✗ {{ $estado }}</span>
@else
    <span class="badge amarillo">⏳ {{ $estado }}</span>
@endif