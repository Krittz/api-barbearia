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
            'phone' => 'required|phone:BR'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'address.required' => 'O endereço é obrigatório.',
            'phone.required' => 'O telefone é obrigatório.',
            'phone.phone' => 'O telefone informado não é válido.'
        ];
    }
}
