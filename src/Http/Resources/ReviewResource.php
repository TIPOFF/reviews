<?php

namespace Tipoff\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'text' => $this->text,
            'name' => $this->name,
            'initial' => $this->initial,
            'photo' => $this->photo,
            'date' => $this->date,
        ];
    }
}
