<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardarTransaccionRequest extends FormRequest
{
    /**
     * Laboratorio 2: authorize()
     * Cambiamos a true para permitir la petición
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Laboratorio 3: rules()
     * Reglas de validación (incluyendo la Misión A min:3)
     */
    public function rules(): array
    {
        return [
            'comercio_id'    => 'required|exists:comercios,id',
            'cliente_nombre' => 'required|string|min:3|max:255',
            'monto'          => 'required|numeric|min:0.01',
        ];
    }

    /**
     * Laboratorio 4: messages()
     * Mensajes personalizados en español
     */
    public function messages(): array
    {
        return [
            'cliente_nombre.required' => 'Debes indicar el nombre del cliente.',
            'cliente_nombre.min'      => 'El nombre del cliente es demasiado corto.',
            'monto.required'          => 'Debes indicar un monto.',
            'monto.numeric'           => 'El monto debe ser un número.',
            'monto.min'               => 'El monto debe ser mayor a cero.',
        ];
    }

    /**
     * Laboratorio 5: attributes()
     * Nombres legibles para los atributos en errores genéricos
     */
    public function attributes(): array
    {
        return [
            'cliente_nombre' => 'nombre del cliente',
            'monto'          => 'monto de la transacción',
            'comercio_id'    => 'comercio',
        ];
    }
}