<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppViewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {

        $return = [
            'id'                 => $this->id,
            'type'               => [
                'id'      => $this->type->id,
                'title'   => $this->type->title,
                'titleFa' => $this->type->title_fa,
                'content' => $this->type->content,
            ],
            'title'              => $this->title,
            'titleColor'         => $this->title_color,
            'description'        => $this->description,
            'descriptionColor'   => $this->description_color,
            'action'             => $this->action,
            'actionColor'        => $this->action_color,
            'needSpace'          => $this->need_space ? 1 : 0,
            'backgroundImage'    => $this->background["path"],
            'backgroundColor'    => $this->background_color,
            'hasBackgroundImage' => $this->background['model'] ? 1 : 0,
            'createdAt'          => $this->created_at->format('Y-m-d H:i:s'),
        ];

        if ($this->type->content == "carwash") {
            $return['carwashes'] = CarwashResource::collection($this->carwashes()->paginate($request->number));
        } else if ($this->type->content == "product") {
            $return['ads'] = ProductResource::collection($this->products()->paginate($request->number));
        }


        return $return;

    }
}
