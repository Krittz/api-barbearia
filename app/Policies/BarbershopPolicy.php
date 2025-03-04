<?php

namespace App\Policies;

use App\Enum\UserRole;
use App\Exceptions\UnauthorizedException;
use App\Models\Barbershop;
use App\Models\User;

class BarbershopPolicy
{

    public function store(User $authenticatedUser)
    {
        if ($authenticatedUser->role !== UserRole::OWNER) {
            throw new UnauthorizedException('Ação não permitida.');
        }
        return true;
    }

    public function update(User $authenticatedUser, Barbershop $barbershop)
    {
        if ($authenticatedUser->role !== UserRole::ADMIN && $authenticatedUser->id !== $barbershop->owner_id) {
            throw new UnauthorizedException('Ação não permitida.');
        }
        return true;
    }
    public function delete(User $authenticatedUser, Barbershop $barbershop)
    {
        if ($authenticatedUser->role !== UserRole::ADMIN && $authenticatedUser->id !== $barbershop->owner_id) {
            throw new UnauthorizedException('Ação não permitida.');
        }
        return true;
    }
}
