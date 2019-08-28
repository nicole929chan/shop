<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPlansPolicy
{
    use HandlesAuthorization;

    public function show(User $user, User $routeUser)
    {
        return $user->is($routeUser);
    }
}
