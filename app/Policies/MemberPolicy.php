<?php

namespace App\Policies;

use App\Models\Member;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MemberPolicy
{
    use HandlesAuthorization;

    public function show(Member $authMember, Member $member)
    {
        return $authMember->admin || $authMember->id == $member->id;
    }

}
