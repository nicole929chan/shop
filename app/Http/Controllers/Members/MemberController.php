<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Http\Resources\MemberIndexResource;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::where('admin', 0)->latest()->paginate(10);        

        return MemberIndexResource::collection($members);
    }

    public function show(Member $member)
    {
        $valid = (is_null($member->activity)) ? false : $member->activity->getValid();

        $added = false;
        
        $user = auth()->guard('api')->user();
        if ($user) {
            $added = !!User::whereHas('plans', function (Builder $q) use ($member, $user) {
                $q->where('member_id', $member->id)
                    ->where('user_id', $user->id);
            })->first();
        }

        return (new MemberResource($member))
            ->additional([
                'meta' => [
                    'valid' => $valid,
                    'added' => $added
                ]
            ]);
    }
}
