<?php

namespace App\Http\Controllers\Admin\Point;

use App\Http\Controllers\Controller;
use App\Models\Point;
use App\Models\User;
use Illuminate\Http\Request;

class PointController extends Controller
{
    public function getPoints($id)
    {
        $user = User::whereCode($id)->first();

       return view('points.show', compact('user'));
    }

    public function store(Request $request)
    {
        $user = User::whereCode($request->code)->first();
        
        Point::create([
            'user_id' => $user->id,
            'member_id' => $request->member_id,
            'points' => $request->points
        ]);

    }
}
