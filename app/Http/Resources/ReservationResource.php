<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function Symfony\Component\Translation\t;

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
            "id"        => $this->id,
            "carwash"   => [
                "id"    => $this->carwash->id,
                "title" => $this->carwash->title,
            ],
            "status"    => $this->status,
            "price"     => $this->price,
            "service"   => new LockServiceResource($this->services()->first()),
            "products"  => LockProductResource::collection($this->products),
            "address"   => $this->address ? new AddressResource($this->address) : null,
            "score"     => new ScoreResource($this->score),
            'createdAt' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
