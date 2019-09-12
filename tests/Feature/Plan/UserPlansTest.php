<?php

namespace Tests\Feature\Plan;

use App\Models\Member;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserPlansTest extends TestCase
{
    use RefreshDatabase;

    public function test_未授權的使用者不能存取使用者優惠計畫()
    {
        $this->json('GET', 'api/user/1/plans')
            ->assertStatus(401);
    }

    public function test_使用者只能取得自己參與的優惠計畫()
    {
        $user = factory(User::class)->create();
        $anotherUser = factory(User::class)->create();
        
        $this->jsonAs($user, 'GET', "api/user/{$anotherUser->id}/plans")
            ->assertStatus(403);
    }

    public function test_取得使用者參與的所有優惠計畫()
    {
        $user = factory(User::class)->create();
        $members = factory(Member::class, 3)->create();
        $user->plans()->attach([
            $members[0]->id => ['card' => 'shareCard1'],
            $members[1]->id => ['card' => 'shareCard2']
        ]);
        
        $this->jsonAs($user, 'GET', "api/user/{$user->id}/plans")
            ->assertJsonCount(2, 'data');
    }

    public function test_取得使用者參與的一項優惠計畫()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $member = factory(Member::class)->create();
        $user->plans()->attach(
            $member->id, ['card' => 'shareCard']
        );
        
        $this->jsonAs($user, 'GET', "api/user/{$user->id}/plans?member_id={$member->id}")
            ->assertJsonStructure([
                'data' => [
                    'member',
                    'card',
                    'redeem'
                ]
            ]);
    }
}
