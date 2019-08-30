<?php

namespace App\Http\Controllers\Admin\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:web']);
    }

    public function show(Member $member)
    {
        $this->authorize('show', $member);

        return view('members.show', compact('member'));
    }
}
