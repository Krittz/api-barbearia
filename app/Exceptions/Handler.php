<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler
{
    public function render(Throwable $e)
    {
        if ($e instanceof AuthenticationException) {
            return response()->json([
                'status' => 'error',
                'message' => 'Usuário não autenticado.',
                'code' => 401,
            ], 401);
        }
        if ($e instanceof UnauthorizedException) {
            return $e->render();
        }
        if ($e instanceof AuthorizationException) {
            return response()->json([
                'status' => 'error',
                'message' => 'Acesso não autorizado.',
                'code' => 403,
            ], 403);
        }

        if ($e instanceof ValidationException) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'code' => 422,
            ], 422);
        }
        if ($e instanceof NotFoundHttpException) {
            return response()->json([
                'status' => 'error',
                'message' => 'Nenhum resultado encontrado.',
                'code' => 404,
            ], 404);
        }
        if ($e instanceof Response) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'code' => $e->getStatusCode(),
            ], $e->getStatusCode());
        }

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'code' => 500,
        ], 500);
    }
}
