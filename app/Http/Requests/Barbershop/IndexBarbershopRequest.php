<?php

namespace App\Http\Requests\Barbershop;

use Illuminate\Foundation\Http\FormRequest;

class IndexBarbershopRequest extends FormRequest
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
            'search' => 'nullable|string',
            'sort_by' => 'nullable|in:name',
            'order' => 'nullable|in:asc,desc'
        ];
    }
    public function messages()
    {
        return [
            'search.string' => 'Use apenas palavras na busca.',
            'sort_by.in' => 'Erro, modo de ordenação indisponível.',
            'order.in' => 'Erro, modo de ordenação inválido.'
        ];
    }
}
