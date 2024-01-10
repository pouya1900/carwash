<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "carwash"  => [
                "id"    => $this->carwash->id,
                "title" => $this->carwash->title,
            ],
            "status"   => $this->status,
            "price"    => $this->price,
            "services" => ServiceResource::collection($this->services),
            "products" => ProductResource::collection($this->products),
            "address"  => $this->address ? new AddressResource($this->address) : [],
        ];
    }
}
