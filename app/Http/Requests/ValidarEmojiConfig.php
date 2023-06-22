<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidarEmojiConfig extends FormRequest
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
            'enojo' => ['string', 'max:50'],
            'like' => ['string', 'max:50'],
            'comentar' => ['string', 'max:50'],
            'compartir' => ['string', 'max:50'],
        ];
    }
}
