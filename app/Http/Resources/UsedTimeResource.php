<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsedTimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"          => $this->id,
            "reservation" => [
                "id" => $this->reservation->id,
            ],
            "start"       => $this->start,
            "end"         => $this->end,
        ];
    }
}
