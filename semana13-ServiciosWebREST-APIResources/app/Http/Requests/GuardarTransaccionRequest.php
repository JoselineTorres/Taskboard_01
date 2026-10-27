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
        // El comercio debe existir...
        $regla = Rule::exists('comercios', 'id');

        // ...y, si hay usuario con sesión (web), debe ser suyo.
        // La API de hoy no tiene login: se cierra con tokens la próxima clase.
        if ($this->user()) {
            $regla = $regla->where('user_id', $this->user()->id);
        }

        return [
            'comercio_id'    => ['required', $regla],
            'cliente_nombre' => 'required|string|min:3|max:255',
            'monto'          => 'required|numeric|min:0.01',
        ];
    }

    public function messages(): array
    {
        return [
            'comercio_id.exists'      => 'El comercio seleccionado no es válido.',
            'cliente_nombre.required' => 'Debes indicar el nombre del cliente.',
            'cliente_nombre.min'      => 'El nombre del cliente es demasiado corto.',
            'monto.required'          => 'Debes indicar un monto.',
            'monto.numeric'           => 'El monto debe ser un número.',
            'monto.min'               => 'El monto debe ser mayor a cero.',
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