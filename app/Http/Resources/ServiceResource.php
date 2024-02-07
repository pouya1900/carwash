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
            "id"          => $this->id,
            "title"       => $this->base->title,
            "description" => $this->base->description ? json_decode($this->base->description, true) : [],
            "items"       => BaseItemResource::collection($this->items),
            "type"        => TypeResource::collection($this->types),
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
