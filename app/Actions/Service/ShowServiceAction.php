<?php

namespace App\Actions\Service;

use App\Models\Service;

class ShowServiceAction
{
    public function __invoke(int $id)
    {
        return Service::with('barbershop')->findOrFail($id);
    }
}
