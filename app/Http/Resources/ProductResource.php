<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use function Couchbase\defaultDecoder;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description ?? '',
            'price'       => intval($this->price) ?? 0,
            'carwash'     => [
                "id"    => $this->carwash->id,
                "title" => $this->carwash->title,
            ],
            'logo'        => new ImageResource($this->logo),
            'images'      => ImageResource::collection($this->images),
            'createdAt'   => $this->created_at->format('Y-m-d H:i:s'),
        ];

    }
}
