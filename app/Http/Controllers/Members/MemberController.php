<?php

namespace App\Http\Controllers\Members;

use Illuminate\Http\Request;
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
        $members = Member::where('admin', 0)->get();

        return MemberIndexResource::collection($members);
    }

    public function show(Member $member, Request $request)
    {
        $valid = (is_null($member->activity)) ? false : $member->activity->getValid();

        $added = false;
        $user = User::find($request->userId);

        if ($user) {
            $added = !!$user->whereHas('plans', function (Builder $q) use ($member) {
                $q->where('member_id', $member->id);
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
