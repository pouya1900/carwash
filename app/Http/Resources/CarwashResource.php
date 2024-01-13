<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarwashResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"           => $this->id,
            "title"        => $this->title ?? "",
            "lat"          => $this->lat ?? "",
            "long"         => $this->long ?? "",
            "address"      => $this->address ?? "",
            "city"         => $this->city ? $this->city->title : "",
            "state"        => $this->state ? $this->state->title : "",
            "productCount" => $this->product_count ?? "",
            "payment"      => $this->payment ?? "",
            "status"       => $this->status ?? "",
            "type"         => $this->type ?? "",
            "logo"         => new ImageResource($this->logo),
        ];
    }
}
