<?php

namespace App\Actions\Barbershop;

use App\Models\Barbershop;

class ShowBarbershopAction
{
    public function __invoke(int $id)
    {
        return Barbershop::findOrFaril($id);
    }
}
