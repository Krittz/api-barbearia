<?php

namespace App\Http\Controllers\Api;

use App\Actions\Barbershop\IndexBarbershopAction;
use App\Actions\Barbershop\StoreBarbershopAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Barbershop\IndexBarbershopRequest;
use App\Http\Requests\Barbershop\StoreBarbershopRequest;
use App\Http\Resources\BarbershopResource;
use App\Models\Barbershop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BarbershopController extends Controller
{

    public function index(IndexBarbershopRequest $request, IndexBarbershopAction $action)
    {
        $barbershops = $action($request);
        return BarbershopResource::collection($barbershops);
    }
    public function store(StoreBarbershopRequest $request, StoreBarbershopAction $action)
    {
        Gate::authorize('store', Barbershop::class);
        $barbershop = $action($request->validated(), $request->user());
        return new BarbershopResource($barbershop);
    }
    public function show(Barbershop $barbershop)
    {
        return new BarbershopResource($barbershop);
    }
    public function update() {}
    public function destroy() {}
}
