<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:web']);
    }

    public function showChangeForm(Member $member)
    {
        $this->authorize('show', $member);
        
        return view('auth.passwords.change', compact('member'));
    }

    public function change(Member $member, Request $request)
    {
        $this->authorize('show', $member);

        $attributes = $request->validate([
            'password' => 'required|confirmed|min:6'
        ]);
        
        $member->password = bcrypt($attributes['password']);
        $member->save();

        return redirect(route('show.change.form', [$member->id]))->with('flash_message', 'Password Changed!');
    }
}
