<?php

namespace App\Http\Controllers\Members;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MemberResource;
use App\Models\Member;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::get();

        return MemberResource::collection($members);
    }

    public function show(Member $member)
    {
        return new MemberResource($member);
    }
}
