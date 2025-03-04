<?php

namespace App\Actions\Service;

use App\Models\Service;

class StoreServiceAction
{
    /**
     * Create a new class instance.
     */
    public function __invoke(array $data)
    {
        return Service::create($data);
    }
}
