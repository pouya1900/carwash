<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "text"      => $this->text,
            "sender"    => $this->sender,
            'createdAt' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
