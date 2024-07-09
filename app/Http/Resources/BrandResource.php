<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $type_id = $this->pivot?->type_id;

        return [
            "id"    => $this->id,
            "title" => $this->title,
            "model" => ModelResource::collection($this->models()->when($type_id, function ($q) use ($type_id) {
                return $q->where("type_id", $type_id);
            })->get()),
            "logo"  => new ImageResource($this->logo),
        ];
    }
}
