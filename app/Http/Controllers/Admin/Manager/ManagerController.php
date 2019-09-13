<?php

namespace App\Http\Controllers\Admin\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\ManagerStoreRequest;
use App\Models\Member;

class ManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:web', 'admin']);
    }

    public function index()
    {
        $members = Member::orderBy('admin', 'desc')->orderBy('name')->paginate(20);

        if(request()->wantsJson()) {
            return $members;
        }

        return view('manager.index', compact('members'));
    }

    public function create()
    {
        return view('manager.create');
    }

    public function store(ManagerStoreRequest $request)
    {
        $member = Member::create([
            'name' => $request->name,
            'code' => '123456',
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'email' => $request->email,
            'password' => 'password',
            'start_date' => $request->start_date,
            'finish_date' => $request->finish_date,
            'logo' => 'images/logo.jpg'
        ]);

        if($logo = $request->file('logo')) {
            $member->logo = $logo->store("images/members/{$member->id}", 'public');
            $member->save();
        }

        return redirect(route('manager.show', [$member->id]));
    }

    public function show(Member $member)
    {
        $member->load('activity');
        
        return view('manager.show', compact('member'));
    }
}
