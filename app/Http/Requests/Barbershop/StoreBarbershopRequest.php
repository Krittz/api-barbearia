<?php

namespace App\Http\Requests\Barbershop;

use App\Models\Barbershop;
use Illuminate\Foundation\Http\FormRequest;

class StoreBarbershopRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'ddd' => 'required|string|size:2|regex:/^\d{2}$/',
            'phone' => 'required|string|size:9|regex:/^\d{9}$/'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'address.required' => 'O endereço é obrigatório.',
            'ddd.required' => 'O DDD é obrigatório.',
            'ddd.size' => 'O DDD deve ter 2 dígitos.',
            'phone.required' => 'O telefone é obrigatório.',
            'phone.size' => 'O telefone deve ter 9 dígitos.'
        ];
    }
}
