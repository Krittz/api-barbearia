<?php

namespace App\Actions\Barbershop;

use App\Models\Barbershop;

class DeleteBarbershopAction
{
   
    public function __invoke(Barbershop $barbershop)
    {
        $barbershop->delete();
    }
}
