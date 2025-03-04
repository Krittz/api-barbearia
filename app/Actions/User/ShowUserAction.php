<?php

namespace App\Actions\User;

use App\Models\User;

class ShowUserAction
{
    public function __invoke(int $id): User
    {
        return User::findOrFail($id);
    }
}
