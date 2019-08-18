<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\PrivateUserResource;

class RegisterController extends Controller
{
    public function action(RegisterRequest $request)
    {
        $user = User::create($request->only(['name', 'email', 'password']));

        return new PrivateUserResource($user);
    }
}
