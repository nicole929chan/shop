<?php

namespace App\Http\Controllers\Admin\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\ActivityStoreRequest;
use App\Http\Requests\Manager\ActivityUpdateRequest;
use App\Models\Activity;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:web', 'admin']);
    }

    public function store(ActivityStoreRequest $request)
    {
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

    public function update(Activity $activity, ActivityUpdateRequest $request)
    {
        $activity->update($request->only('points', 'description', 'activity_start', 'activity_end'));

        if ($image = $request->file('image_path')) {
            Storage::disk('public')->delete($activity->image_path);
            $image_path = $image->store("images/members/{$activity->member->id}", 'public');
            $activity->image_path = $image_path;
            $activity->save();
        }
        
        return $activity;
    }
}
