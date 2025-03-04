<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginAction
{
    public function __invoke(array $credentials)
    {
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $user = Auth::user();
            $token = $user->createToken('CrAnBarber')->plainTextToken;
            return $token;
        }
        throw ValidationException::withMessages([
            'email' => ['As credenciais fornecidas estão incorretas']
        ]);
    }
}
