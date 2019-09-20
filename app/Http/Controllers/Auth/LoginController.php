<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\PrivateUserResource;

class LoginController extends Controller
{
    public function action(LoginRequest $request)
    {
        $token = auth()->attempt(['email' => $request->email, 'password' => $request->password]);

        if(!$token) {
            return response()->json([
                'errors' => [
                    'email' => [
                        'Could not sign you in with those details.'
                    ]
                ]
            ], 422);
        }

        $resource = new PrivateUserResource($request->user());

        return $resource->additional([
            'meta' => [
                'token' => $token
            ]
        ]);
    }
}
