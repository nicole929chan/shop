<?php

namespace App\Http\Controllers\Admin\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:web']);
    }

    public function index(Member $member)
    {
        $users = $member->users;

        if(request()->wantsJson()) {
            return $users;
        }

        return view('members.users.index', compact('member', 'users'));
    }
}
