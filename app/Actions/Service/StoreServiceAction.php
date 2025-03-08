<?php

namespace App\Actions\Service;

use App\Models\Service;

class StoreServiceAction
{
    public function __invoke(array $data)
    {
        return Service::create($data);
    }
}
