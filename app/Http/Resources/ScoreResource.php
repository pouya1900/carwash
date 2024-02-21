<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScoreResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Http\Request $searchString
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            "user"      => new UserResource($this->reservation->user),
            "carwashId" => $this->scorable->id,
            "score"     => $this->rate,
            "comment"   => $this->comment ?? "",
            "reply"     => $this->reply ?? "",
            "services"  => ServiceTitleResource::collection($this->reservation->services),
            "createdAt" => $this->created_at?->format('Y-m-d H:i:s'),
        ];

    }


}

