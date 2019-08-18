<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_使用者密碼必須編碼過()
    {
        $user = factory(User::class)->create(['password' => 'foo']);

        $this->assertNotEquals('foo', $user->password);
    }
}
