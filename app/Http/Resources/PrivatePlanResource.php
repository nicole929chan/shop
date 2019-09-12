<?php

namespace App\Http\Resources;

use App\Models\Member;
use Illuminate\Http\Resources\Json\JsonResource;

class PrivatePlanResource extends JsonResource
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
            'member' => new MemberResource(Member::find($this->pivot->member_id)),
            'card' => url('storage/'.$this->pivot->card),
            'redeem' => url('storage/'.$this->pivot->redeem)
        ];
    }
}
