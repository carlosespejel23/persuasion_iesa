<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidarDeudor extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'usuario_id' => ['integer', $this->route('id')],
            'nombre' => ['string', 'max:255'],
            'apellidoPaterno' => ['string', 'max:255'],
            'apellidoMaterno' => ['string', 'max:255'],
            'email' => ['email', 'max:255'],
            'telefono' => ['string', 'max:255'],
            'nacionalidad' => ['string', 'max:255'],
            'curp' => ['nullable', 'string', 'max:18'],
            'rfc' => ['nullable', 'string', 'max:13'],
            'monto_a_pagar' => ['numeric', 'between:0,9999999.99'],
        ];
    }
}
