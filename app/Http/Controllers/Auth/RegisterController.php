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
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'birth_year' => sprintf("%04d", $request->birth_year),
            'birth_month' => sprintf("%02d", $request->birth_month)
        ]);

        return new PrivateUserResource($user);
    }
}
