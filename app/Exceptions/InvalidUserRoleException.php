<?php

namespace App\Exceptions;

use Exception;

class InvalidUserRoleException extends Exception
{
    public function render()
    {
        return response()->json([
            'status' => 'error',
            'message' => $this->getMessage(),
            'code' => 403,
        ], 403);
    }
}
