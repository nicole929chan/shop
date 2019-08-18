<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_註冊使用者()
    {
        $this->json('POST', 'api/auth/register', [
            'name' => $name = 'Nicole',
            'email' => $email = 'nicole@example.com',
            'password' => 'password'
        ]);

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email
        ]);
    }

    public function test_註冊須填姓名()
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['name']);
    }

    public function test_註冊須填郵件()
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['email']);
    }

    public function test_註冊郵件格式須正確()
    {
        $this->json('POST', 'api/auth/register', ['email' => 'nope'])
            ->assertJsonValidationErrors(['email']);
    }

    public function test_註冊的郵件不能重複()
    {
        $user = factory(User::class)->create();

        $this->json('POST', 'api/auth/register', ['email' => $user->email])
            ->assertJsonValidationErrors(['email']);
    }

    public function test_註冊須填密碼()
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['password']);
    }

    public function test_註冊成功後返回該位使用者資源()
    {
        $this->json('POST', 'api/auth/register', [
            'name' => $name = 'Nicole',
            'email' => $email = 'nicole@example.com',
            'password' => 'password'
        ])->assertJsonFragment(['email' => $email]);
    }

}
