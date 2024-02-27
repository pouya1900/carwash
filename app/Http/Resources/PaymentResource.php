<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'id'     => $this->id,
            "wallet" => $this->wallet,
            "online" => $this->online,
            'total'  => $this->total,
            "status" => $this->status,
        ];

    }
}
