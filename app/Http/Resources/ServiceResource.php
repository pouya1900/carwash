<?php

namespace App\Http\Resources;

use App\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Morilog\Jalali\Jalalian;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $discount = 0;
        if ($j_date = $request->input("date")) {
            $time = $request->input("time");
            $date = Jalalian::fromFormat('Y-m-d', $j_date)->toCarbon();
            $discount_object = Helper::hasDiscount($this->carwash, $date, $time);
            $discount = $discount_object ? $discount_object->value : 0;
        }

        return [
            "id"                => $this->id,
            "title"             => $this->base->title,
            "description"       => $this->base->description ? json_decode($this->base->description, true) : [],
            "items"             => BaseItemResource::collection($this->items),
            "type"              => TypeResource::collection($this->types),
            "duration"          => $this->time,
            'carwash'           => [
                "id"    => $this->carwash->id,
                "title" => $this->carwash->title,
            ],
            "status"            => $this->status,
            "price"             => $this->price,
            "discount"          => max($this->discount, $discount),
            "temporaryDiscount" => $discount > $this->discount,
            'createdAt'         => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
