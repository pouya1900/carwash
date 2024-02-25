<?php

namespace App\Http\Resources;

use App\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Morilog\Jalali\Jalalian;

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
        $available = 0;
        $first_free_time = null;
        if ($j_date = $request->input("date")) {
            $time = $request->input("time");
            $date = Jalalian::fromFormat('Y-m-d', $j_date)->toCarbon();
            $datetime = Jalalian::fromFormat('Y-m-d', $j_date)->addHours($time)->toCarbon();
            $first_free_time = Helper::getFirstFreeTime($this, $date, $time);
            if ($first_free_time == $datetime) {
                $available = 1;
            }

            if ($first_free_time < Carbon::now()->addMinutes(30)) {
                $available = 1;
            }
        }

        return [
            "id"                 => $this->id,
            "title"              => $this->title ?? "",
            "lat"                => $this->lat ?? "",
            "long"               => $this->long ?? "",
            "address"            => $this->address ?? "",
            "city"               => $this->city ? $this->city->title : "",
            "state"              => $this->state ? $this->state->title : "",
            "productCount"       => $this->product_count ?? "",
            "payment"            => $this->payment ?? "",
            "status"             => $this->status ?? "",
            "distance"           => $distance ?? "",
            "message"            => $this->message ?? "",
            "type"               => $this->type ?? "",
            "logo"               => new ImageResource($this->logo),
            "services"           => ServiceResource::collection($this->services),
            "productsCount"      => $this->products->count(),
            'createdAt'          => $this->created_at?->format('Y-m-d H:i:s'),
            "isPromoted"         => $this->promoted ? 1 : 0,
            "isCertified"        => $this->certified ? 1 : 0,
            "isNew"              => Carbon::now()->subDays(5) < $this->created_at ? 1 : 0,
            "isLike"             => $request->user && $this->likes()->where("user_id", $request->user->id)->first() ? 1 : 0,
            "isBookmark"         => $request->user && $this->bookmarks()->where("user_id", $request->user->id)->first() ? 1 : 0,
            "rate"               => +$this->rate,
            "reviewsCount"       => $this->scores()->count(),
            "available"          => $available,
            "firstAvailableTime" => $first_free_time ? jdate(strtotime($first_free_time))->format("Y-m-d H:i") : null,
        ];
    }
}
