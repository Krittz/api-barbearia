<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\LoginAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request, LoginAction $action)
    {
        $validated = $request->validated();
        $token = $action($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Usuário autenticado com sucesso.',
        ])->cookie('token', $token, 60, null, null, false, true);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Acesso revogado com sucesso.'
        ], 200);
    }
}
