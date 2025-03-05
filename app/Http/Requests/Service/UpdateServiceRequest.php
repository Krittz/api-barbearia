<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'duration' => 'sometimes|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'O nome do serviço deve ser constituído por palavras.',
            'description.string' => 'A descrição deve ser constituída por palavras que representem o serviço.',
            'price.numeric' => 'O preço deve ser um número.',
            'price.min' => 'O preço deve ser maior ou igual a 0.',
            'duration.integer' => 'A duração deve ser um número inteiro.',
            'duration.min' => 'A duração deve ser maior ou igual a 1.',
        ];
    }
}
