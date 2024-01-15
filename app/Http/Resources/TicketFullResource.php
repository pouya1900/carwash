<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketFullResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "title"     => $this->title,
            "status"    => $this->status,
            'createdAt' => $this->created_at?->format('Y-m-d H:i:s'),
            "messages"  => MessageResource::collection($this->messages),
        ];
    }
}
