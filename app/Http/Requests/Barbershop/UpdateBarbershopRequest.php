<?php

namespace App\Http\Requests\Barbershop;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBarbershopRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'address' => 'sometimes|string|max:255',
            'ddd' => 'sometimes|string|size:2|regex:/^\d{2}$/',
            'phone' => 'sometimes|string|size:9|regex:/^\d{9}$/'
        ];
    }
    public function messages()
    {
        return [
            'name.string' => 'O nome deve ser formado por palavras.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'address.string' => 'Formato de endereço inválido.',
            'address.max' => 'O endereço não pode ter mais de 255 caracteres.',
            'ddd.size' => 'O DDD deve ter 2 digitos.',
            'ddd.regex' => 'O DDD deve conter apenas números.',
            'phone.size' => 'O telefone deve ter 9 dígitos.',
            'phone.regex' => 'O telefone deve conter apenas números.',
        ];
    }
}
