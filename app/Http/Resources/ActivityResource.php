<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
            'points' => $this->points,
            'description' => $this->description,
            'image_path' => url('storage/'.$this->image_path),
            'activity_start' => $this->activity_start,
            'activity_end' => $this->activity_end
        ];
    }
}
