<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"    => $this->id,
            "type"  => [
                "id"    => $this->type->id,
                "title" => $this->type->title,
            ],
            "brand" => [
                "id"    => $this->brand->id,
                "title" => $this->brand->title,
            ],
            "model" => [
                "id"    => $this->model->id,
                "title" => $this->model->title,
            ],
            "color" => [
                "id"    => $this->color->id,
                "title" => $this->color->title,
            ],
            "year"  => $this->year,

        ];
    }
}
