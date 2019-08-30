<?php

namespace App\Policies;

use App\Models\Member;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MemberPolicy
{
    use HandlesAuthorization;

    public function before(Member $authMember)
    {
        return $authMember->admin;
    }

    public function show(Member $authMember, Member $member)
    {
        return $authMember->id == $member->id;
    }

}
