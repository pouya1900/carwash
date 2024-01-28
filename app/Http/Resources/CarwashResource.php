<?php

namespace App\Http\Resources;

use App\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarwashResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $distance = Helper::getDistance($request->lat, $request->long, $this->lat, $this->long);

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
            "distance"     => $distance ?? "",
            "message"      => $this->message ?? "",
            "type"         => $this->type ?? "",
            "logo"         => new ImageResource($this->logo),
            "services"     => ServiceResource::collection($this->services),
            "products"     => ProductResource::collection($this->products),
            'createdAt'    => $this->created_at?->format('Y-m-d H:i:s'),
            "isPromoted"   => $this->promoted ? 1 : 0,
            "isCertified"  => $this->certified ? 1 : 0,
            "isNew"        => Carbon::now()->subDays(5) < $this->created_at ? 1 : 0,
            "isLike"       => $request->user && $this->likes()->where("user_id", $request->user->id)->first() ? 1 : 0,
            "isBookmark"   => $request->user && $this->bookmarks()->where("user_id", $request->user->id)->first() ? 1 : 0,
        ];
    }
}
