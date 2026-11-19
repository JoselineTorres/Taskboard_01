<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GuardarTransaccionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // El comercio debe existir Y ser del usuario de la sesión (web) o del token (API)
            'comercio_id'    => ['required',
                Rule::exists('comercios', 'id')->where('user_id', $this->user()->id)],
            'cliente_nombre' => 'required|string|min:3|max:255',
            // E-01: máximo · E-02: como mucho dos decimales
            'monto'          => ['required', 'numeric', 'decimal:0,2', 'min:0.01', 'max:99999999.99'],
            // E-03: toda transacción nace Iniciada
            'estado'         => ['prohibited'],
        ];
    }

    public function messages(): array
    {
        return [
            'comercio_id.required'    => 'Debes indicar el comercio.',
            'comercio_id.exists'      => 'El comercio seleccionado no es válido.',
            'cliente_nombre.required' => 'Debes indicar el nombre del cliente.',
            'cliente_nombre.min'      => 'El nombre del cliente es demasiado corto.',
            'monto.required'          => 'Debes indicar un monto.',
            'monto.numeric'           => 'El monto debe ser un número.',
            'monto.min'               => 'El monto debe ser mayor a cero.',
            'monto.max'               => 'El monto no puede superar 99,999,999.99.',
            'monto.decimal'           => 'El monto admite como máximo dos decimales.',
            'estado.prohibited'       => 'El estado no se envía al crear: toda transacción nace Iniciada.',
        ];
    }

    public function attributes(): array
    {
        return [
            'cliente_nombre' => 'nombre del cliente',
            'monto'          => 'monto de la transacción',
            'comercio_id'    => 'comercio',
        ];
    }
}