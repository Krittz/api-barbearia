<?php

namespace App\Http\Requests\User;

use App\Enum\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserIndexRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

   
    public function rules(): array
    {
        return [
            'search' => 'nullable|string',
            'role' => ['nullable', Rule::in(UserRole::values())],
            'sort_by' => 'nullable|in:name,role',
            'order' => 'nullable|in:asc,desc'
        ];
    }
    public function messages()
    {
        return [
            'search.string' => 'Use apenas palavras na busca.',
            'role.in' => 'Erro, tipo de usuário inválido.',
            'sort_by.in' => 'Erro, modo de ordenação indisponível.',
            'order.in' => 'Erro, modo de ordenação inválido.'
        ];
    }
}
