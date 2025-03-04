<?php

namespace App\Http\Requests\User;

use App\Enum\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(UserRole::values())],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve conter apenas letras.',
            'email.email' => 'O e-mail deve ser um endereço de e-mail válido.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.unique' => 'E-mail inválido ou já está em uso.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'As senhas não coincidem.',
            'role.in' => 'O tipo de usuário é inválido.',
            'role.required' => 'Erro ao processar cadastro. Tipo de usuário inválido.',
        ];
    }
}
