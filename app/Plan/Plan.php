<?php

namespace App\Plan;

use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class Plan
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;        
    }

    public function add($memberId, $image)
    {
        $card = $image->store('images/cards', 'public');

        $this->user->plans()->attach($memberId, ['card' => $card]);
    }

    public function getActivity($memberId)
    {
        $member = Member::find($memberId);        

        return $member->activity;
    }
}