<?php

namespace App\Http\Resources;

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
        return [
            'id'             => $this->id,
            'mobile'         => $this->mobile,
            'firstName'      => $this->first_name ?? '',
            'lastName'       => $this->last_name ?? '',
            'fullName'       => $this->full_name ?? '',
            'username'       => $this->username ?? '',
            "image"          => new ImageResource($this->avatar),
            'balance'        => $this->balance ?? 0,
            "pendingGift"    => new GiftResource($this->gifts()->where("status", "pending")->first()),
            "completedGifts" => GiftResource::collection($this->gifts()->where("status", "completed")->get()),
            "receivedGifts"  => GiftResource::collection($this->gifts()->where("status", "received")->get()),
            'createdAt'      => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
