<?php

namespace App\Policies;

use App\Enum\UserRole;
use App\Exceptions\UnauthorizedException;
use App\Models\User;

class UserPolicy
{
    public function viewAny(User $authenticatedUser): bool
    {
        if ($authenticatedUser->role !== UserRole::ADMIN) {
            throw new UnauthorizedException('Acesso não autorizado.');
        }
        return true;
    }
    public function update(User $authenticatedUser, User $user): bool
    {
        if ($authenticatedUser->id !== $user->id) {
            throw new UnauthorizedException('Acesso não autorizado.');
        }
        return true;
    }
    public function delete(User $authenticatedUser): bool
    {
        if ($authenticatedUser->role !== UserRole::ADMIN) {
            throw new UnauthorizedException('Acesso não autorizado.');
        }
        return true;
    }
    public function show(User $authenticatedUser): bool
    {
        if ($authenticatedUser->role !== UserRole::ADMIN) {
            throw new UnauthorizedException('Acesso não autorizado.');
        }
        return true;
    }
}
