<?php

namespace App\Http\Controllers\Admin\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\ActivityStoreRequest;
use App\Models\Activity;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:web']);
    }

    public function store(ActivityStoreRequest $request)
    {
        if(!auth()->guard('web')->user()->admin)
            abort(403);

        $activity = Activity::create([
            'member_id' => $request->member_id,
            'points' => $request->points,
            'description' => $request->description,
            'activity_start' => $request->activity_start,
            'activity_end' => $request->activity_end,
            'image_path' => $request->file('image_path')->store("images/members/{$request->member_id}", 'public')
        ]);

        return $activity;
    }
}
