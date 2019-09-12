<?php

namespace App\Http\Controllers\Plan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MemberResource;
use App\Http\Resources\PrivatePlanResource;
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
        
        if(is_null($request->member_id)) {
            return PrivatePlanResource::collection($user->plans);
        } else {
            $plan = $user->plans()->wherePivot('member_id', $request->member_id)->first();
            return new PrivatePlanResource($plan);
        }
        
        return null;
    }
}
