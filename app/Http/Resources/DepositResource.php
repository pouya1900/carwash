<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepositResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"      => $this->id,
            "bank"    => new BankResource($this->bank),
            "total"   => $this->total,
            "status"  => $this->status,
            "message" => $this->message,
        ];
    }
}
