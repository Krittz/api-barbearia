<?php

namespace App\Http\Controllers\Api;

use App\Actions\Service\DeleteServiceAction;
use App\Actions\Service\IndexServiceAction;
use App\Actions\Service\ShowServiceAction;
use App\Actions\Service\StoreServiceAction;
use App\Actions\Service\UpdateServiceAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Service\IndexServiceRequest;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Barbershop;
use App\Models\Service;
use Illuminate\Support\Facades\Gate;

class ServiceController extends Controller
{
    public function index(Barbershop $barbershop, IndexServiceRequest $request, IndexServiceAction $action)
    {
        $services = $action($barbershop, $request->validated());
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
        $service = $action($service->id);
        return new ServiceResource($service);
    }
    public function update(UpdateServiceRequest $request, Service $service, UpdateServiceAction $action)
    {
        Gate::authorize('update', $service);

        $updatedService = $action($service, $request->validated());
        return new ServiceResource($updatedService);
    }

    public function destroy(DeleteServiceAction $action, Service $service)
    {
        Gate::authorize('delete', $service);
        $action($service);
        return response()->json([
            'status' => 'success',
            'message' => 'Serviço excluído com sucesso.',
        ]);
    }
}
