<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
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
        ];
    }
}
