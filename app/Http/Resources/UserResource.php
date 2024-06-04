<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
        $x = $this->reservations()->where("status", "approved")->whereDoesntHave("score")->orderBy('id', 'desc')->first();
        $last_scorable_reserve = null;
        if ($x && $x->time->start < Carbon::now()->subHours($x->services()->first()->time)) {
            $last_scorable_reserve = $x;
        }

        return [
            'id'                    => $this->id,
            'mobile'                => $this->mobile,
            'firstName'             => $this->first_name ?? '',
            'lastName'              => $this->last_name ?? '',
            'fullName'              => $this->full_name ?? '',
            'username'              => $this->username ?? '',
            'ftm_token'             => $this->firebase_token ?? '',
            'image'                 => new ImageResource($this->avatar),
            'balance'               => $this->balance ?? 0,
            'lat'                   => $this->lat ?? "",
            'long'                  => $this->long ?? "",
            'giftBalance'           => $this->gift_balance ?? 0,
            'pendingGift'           => new GiftResource($this->gifts()->where("status", "pending")->first()),
            'completedGifts'        => GiftResource::collection($this->gifts()->where("status", "completed")->get()),
            'receivedGifts'         => GiftResource::collection($this->gifts()->where("status", "received")->get()),
            'lastScorableReserve'   => new ReservationResource($last_scorable_reserve),
            'lastApprovedReserveId' => $this->reservations()->where("status", "approved")->orderBy('id', 'desc')->first(),
            'createdAt'             => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
