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
            'id' => $this->id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'reviewer' => $this->reviewer,
            'reviewer_photo' => $this->reviewer_photo,
            'created_at' => $this->created_at,
        ];
    }
}
