<?php

namespace App\Actions\User;

use App\Models\User;
use App\Enum\UserRole;
use Illuminate\Support\Facades\Hash;

class StoreUserAction
{
    public function __invoke(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => UserRole::from($data['role']) ?? UserRole::CUSTOMER,
        ]);
    }
}
