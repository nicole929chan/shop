<?php

namespace App\Http\Resources;

use App\Models\Member;
use App\Models\User;
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
            'redeem' => url('storage/'.$this->pivot->redeem),
            'points' => $this->getPoints($this->pivot->user_id, $this->pivot->member_id)
        ];
    }

    public function getPoints($userId, $memberId)
    {
        $user = User::find($userId);
        $user_member_point = $user->pointByMember($memberId);

        if (is_null($user_member_point)) {
            return 0;
        }
        
        return $user_member_point->pivot->points;
    }
}
