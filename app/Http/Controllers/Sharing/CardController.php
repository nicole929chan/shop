<?php

namespace App\Http\Controllers\Sharing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PrivatePlanResource;
use App\Models\User;

class CardController extends Controller
{
    public function action(User $user, Request $request)
    {
        $plan = $user->plans()->wherePivot('member_id', $request->member_id)->first();
        
        return [
            'card' => url('storage/' . $plan->pivot->card)
        ];
    }
}
