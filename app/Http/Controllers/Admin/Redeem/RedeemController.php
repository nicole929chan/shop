<?php

namespace App\Http\Controllers\Admin\Redeem;

use App\Http\Controllers\Controller;
use App\Http\Requests\Redeem\RedeemStoreRequest;
use App\Models\Point;
use App\Models\User;
use App\Models\Member;

class RedeemController extends Controller
{
    public function redeem($code)
    {
        $user = User::whereCode($code)->first();

        if(is_null($user) || $code == 'code') {
            $code = '';
            return view('redeem.show', compact('code'));
        }

       return view('redeem.show', compact('code'));
    }

    public function store(RedeemStoreRequest $request)
    {
        $user = User::whereCode($request->user_code)->first();
        $member = Member::whereCode($request->member_code)->first();
        $points = (-1) * $request->points;

        Point::create([
            'user_id' => $user->id,
            'member_id' => $member->id,
            'points' => $points
        ]);

        return redirect('redeem/code')->with('flash_message', 'done!');
    }
}
