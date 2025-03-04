<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => 'R$' . $this->price,
            'duration' => $this->duration,
            'barbershop' => [
                'id' => $this->barbershop->id,
                'name' => $this->barbershop->name,
            ],
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
