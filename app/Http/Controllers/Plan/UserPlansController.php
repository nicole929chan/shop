<?php

namespace App\Http\Controllers\Plan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MemberResource;
use App\Models\User;

class UserPlansController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function action(User $user, Request $request)
    {
        $this->authorize('show', $user);

        $member_id = $request->member_id;

        if(is_null($member_id)) {
            if($user->plans) {
                return MemberResource::collection($user->plans);
            }
        } else {
            $plan = $user->plans()->wherePivot('member_id', $member_id)->first();
            if($plan) {
                return new MemberResource($plan);
            }
        }
        
        return null;
    }
}
