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
            "id"        => $this->id,
            "type"      => $this->type ? [
                "id"    => $this->type->id,
                "title" => $this->type->title,
            ] : null,
            "brand"     => $this->model ? [
                "id"    => $this->model->brand->id,
                "title" => $this->model->brand->title,
            ] : null,
            "model"     => $this->model ? [
                "id"    => $this->model->id,
                "title" => $this->model->title,
            ] : null,
            "color"     => $this->color ? [
                "id"    => $this->color->id,
                "title" => $this->color->title,
            ] : null,
            "year"      => $this->year,
            "image"     => new ImageResource($this->image),
            "plate1"    => $this->plate1,
            "plate2"    => $this->plate2,
            "plate3"    => $this->plate3,
            "plate4"    => $this->plate4,
            "default"   => $this->is_default ? 1 : 0,
            'createdAt' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
