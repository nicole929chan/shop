<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_登入時郵件必填()
    {
        $this->json('POST', 'api/auth/login')
            ->assertJsonValidationErrors(['email']);
    }

    public function test_登入時密碼必填()
    {
        $this->json('POST', 'api/auth/login')
            ->assertJsonValidationErrors(['password']);
    }

    public function test_登入驗證成功後返回該名使用者資源()
    {
        $user = factory(User::class)->create(['password' => 'password']);

        $response = $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertJsonFragment([
            'email' => $user->email
        ]);
    }

    public function test_登入驗證成功後返回token()
    {
        $user = factory(User::class)->create(['password' => 'password']);

        $response = $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertJsonStructure([
            'meta' => [
                'token'
            ]
        ]);
    }

    public function test_登入驗證失敗則返回錯誤訊息告知()
    {
        $response = $this->json('POST', 'api/auth/login', [
            'email' => 'foo@example.com',
            'password' => 'password'
        ]);

        $response->assertJsonValidationErrors(['email']);
    }
}
