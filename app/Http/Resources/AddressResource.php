<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "state"       => $this->state->title,
            "city"        => $this->city->title,
            "area"        => $this->area ?? "",
            "block"       => $this->block ?? "",
            "street"      => $this->street ?? "",
            "lat"         => $this->lat ?? "",
            "long"        => $this->long ?? "",
            "description" => $this->description ?? "",
            "pluck"       => $this->pluck ?? "",
            "floor"       => $this->floor ?? "",
        ];
    }
}
