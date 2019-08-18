<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MeTest extends TestCase
{
    use RefreshDatabase;

    public function test_未通過身份驗證不能存取使用者資源()
    {
        $this->json('GET', 'api/auth/me')
            ->assertStatus(401);
    }

    public function test_使用token通過身份驗證的使用者能存取自己的使用者資源()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'GET', 'api/auth/me')
            ->assertJsonFragment(['email' => $user->email]);
    }
}
