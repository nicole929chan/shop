<?php

namespace App\Http\Resources;

class MemberResource extends MemberIndexResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'activity' => new ActivityResource($this->activity)
        ]);
    }
}
