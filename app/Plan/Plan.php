<?php

namespace App\Plan;

use App\Models\User;

class Plan
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;        
    }

    public function add($memberId)
    {
        $this->user->plans()->attach($memberId);
    }
}