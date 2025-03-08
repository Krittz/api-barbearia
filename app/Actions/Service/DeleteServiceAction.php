<?php

namespace App\Actions\Service;

use App\Models\Service;

class DeleteServiceAction
{
    public function __invoke(Service $service)
    {
        $service->delete();
    }
}
