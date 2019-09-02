<?php

namespace App\Http\Controllers\Admin\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;

class ManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:web']);
    }

    public function index()
    {
        if(!auth()->guard('web')->user()->admin)
            abort(403);

        $members = Member::orderBy('name')->get();

        if(request()->wantsJson()) {
            return $members;
        }

        return view('manager.index', compact('members'));
    }
}
