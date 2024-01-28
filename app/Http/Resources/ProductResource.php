<?php

namespace App\Http\Resources;

use App\Helper;
use Carbon\Carbon;
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
        $distance = Helper::getDistance($request->lat, $request->long, $this->carwash->lat, $this->carwash->long);

        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'description'  => $this->description ?? '',
            'price'        => intval($this->price) ?? 0,
            'carwash'      => [
                "id"       => $this->carwash->id,
                "title"    => $this->carwash->title,
                "distance" => $distance ?? "",
            ],
            'category'     => [
                "id"    => $this->category->id,
                "title" => $this->category->title,
            ],
            'logo'         => new ImageResource($this->logo),
            'images'       => ImageResource::collection($this->images),
            'createdAt'    => $this->created_at?->format('Y-m-d H:i:s'),
            "isNew"        => Carbon::now()->subDays(5) < $this->created_at ? 1 : 0,
            "isBestSeller" => $this->isBestSeller,
            "discount"     => $this->discount,
            "isRated"      => $this->isRated,
            "isLike"       => $request->user && $this->likes()->where("user_id", $request->user->id)->first() ? 1 : 0,
            "isBookmark"   => $request->user && $this->bookmarks()->where("user_id", $request->user->id)->first() ? 1 : 0,
        ];

    }
}
