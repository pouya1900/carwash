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
            "title"       => $this->title,
            "description" => $this->description,
            "items"       => json_decode($this->items, true),
            "time"        => $this->time,
            'carwash'     => [
                "id"    => $this->carwash->id,
                "title" => $this->carwash->title,
            ],
            "status"      => $this->status,
            "price"       => $this->price,
            "discount"    => $this->discount,
            'createdAt'   => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
