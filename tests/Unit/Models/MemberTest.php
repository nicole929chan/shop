<?php

namespace Tests\Unit\Models;

use App\Models\Member;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_使用者能參與多位店家的優惠()
    {
        $user = factory(User::class)->create();
        $member = factory(Member::class)->create();

        $user->plans()->attach($member, ['card' => 'images/cards/xyz.jpg']);

        $this->assertEquals(1, $user->plans->count());

    }
}
