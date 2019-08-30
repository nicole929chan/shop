<?php

namespace App\Http\Controllers\Members;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MemberIndexResource;
use App\Http\Resources\MemberResource;
use App\Models\Member;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all();

        return MemberIndexResource::collection($members);
    }

    public function show(Member $member)
    {
        $valid = (is_null($member->activity)) ? false : $member->activity->getValid();

        return (new MemberResource($member))
            ->additional([
                'meta' => [
                    'valid' => $valid
                ]
            ]);
    }
}
