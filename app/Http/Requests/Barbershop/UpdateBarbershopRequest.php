<?php

namespace App\Http\Requests\Barbershop;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBarbershopRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'address' => 'sometimes|string|max:255',
            'phone' => 'sometimes|phone:BR'
        ];
    }
    public function messages()
    {
        return [
            'name.string' => 'O nome deve ser formado por palavras.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'address.string' => 'Formato de endereço inválido.',
            'address.max' => 'O endereço não pode ter mais de 255 caracteres.',
            'phone.phone' => 'O telefone informado não é válido.'
        ];
    }
}
