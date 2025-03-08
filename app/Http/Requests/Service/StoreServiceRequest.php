<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
  
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'barbershop_id' => 'required|exists:barbershops,id',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'O nome do serviço é obrigatório.',
            'price.required' => 'O preço do serviço é obrigatório.',
            'price.min' => 'O preço deve ser maior ou igual a 0.',
            'duration.required' => 'A duração do serviço é obrigatória.',
            'duration.min' => 'A duração deve ser maior ou igual a 1.',
            'barbershop_id.required' => 'A barbearia é obrigatória.',
            'barbershop_id.exists' => 'A barbearia selecionada não existe.',
        ];
    }
}
