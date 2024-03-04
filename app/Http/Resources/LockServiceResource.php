<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LockServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"          => $this->id,
            "title"       => $this->title,
            "description" => $this->description ? json_decode($this->description, true) : [],
            "items"       => $this->items ? json_decode($this->items, true) : [],
            "duration"    => $this->time,
            'carwash'     => [
                "id"    => $this->carwash->id,
                "title" => $this->carwash->title,
            ],
            "price"       => $this->price,
            "discount"    => $this->discount,
            'createdAt'   => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
