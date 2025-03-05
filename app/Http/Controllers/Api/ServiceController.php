<?php

namespace App\Http\Controllers\Api;

use App\Actions\Service\IndexServiceAction;
use App\Actions\Service\ShowServiceAction;
use App\Actions\Service\StoreServiceAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Service\IndexServiceRequest;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Barbershop;
use App\Models\Service;
use Illuminate\Support\Facades\Gate;

class ServiceController extends Controller
{
    public function index(Barbershop $barbershop, IndexServiceRequest $request, IndexServiceAction $action)
    {
        // Lista os serviços da barbearia
        $services = $action($barbershop, $request->validated());

        // Retorna a lista de serviços
        return ServiceResource::collection($services);
    }
    public function store(StoreServiceRequest $request, StoreServiceAction $action)
    {
        Gate::authorize('store', Service::class);

        $service = $action($request->validated());

        return new ServiceResource($service);
    }

    public function show(Service $service, ShowServiceAction $action)
    {
        // Busca o serviço pelo ID
        $service = $action($service->id);

        // Retorna o serviço
        return new ServiceResource($service);
    }
}
