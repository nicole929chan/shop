<?php

namespace App\Http\Controllers\Admin\Point;

use App\Http\Controllers\Controller;
use App\Http\Requests\Point\PointStoreRequest;
use App\Models\Member;
use App\Models\Point;
use App\Models\User;

class PointController extends Controller
{
    /**
     * 贈與點數表單
     * 
     * @param integer $code 使用者代碼
     * @return void
     */
    public function getPoints($code)
    {
        $user = User::whereCode($code)->first();

        if(is_null($user) || $code == 'code') {
            $code = '';
            return view('points.show', compact('code'));
        }

       return view('points.show', compact('code'));
    }

    /**
     * 贈與點數
     *
     * @param Request $request
     * @return void
     */
    public function store(PointStoreRequest $request)
    {
        $user = User::whereCode($request->user_code)->first();
        $member = Member::whereCode($request->member_code)->first();
        
        Point::create([
            'user_id' => $user->id,
            'member_id' => $member->id,
            'points' => $request->points
        ]);
    }
}
