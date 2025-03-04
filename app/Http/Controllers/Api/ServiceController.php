<?php

namespace App\Http\Controllers\Api;

use App\Actions\Service\StoreServiceAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ServiceController extends Controller
{
    public function store(StoreServiceRequest $request, StoreServiceAction $action)
    {
        Gate::authorize('store', Service::class);

        $service = $action($request->validated());

        return new ServiceResource($service);
    }
}
