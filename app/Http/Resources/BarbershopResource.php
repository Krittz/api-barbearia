<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BarbershopResource extends JsonResource
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
            'address' => $this->address,
            'phone' => '(' . $this->ddd . ') ' . $this->phone,
            'owner' => new UserResource($this->whenLoaded('owner')),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
