<?php

namespace App\Actions\Barbershop;

use App\Models\Barbershop;
use App\Models\User;

class StoreBarbershopAction
{
    public function __invoke(array $data, User $owner)
    {
        $barbershop = new Barbershop($data);
        $barbershop->owner()->associate($owner);
        $barbershop->save();

        return $barbershop;
    }
}
