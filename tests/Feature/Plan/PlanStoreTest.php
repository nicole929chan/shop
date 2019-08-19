<?php

namespace Tests\Feature\Plan;

use App\Models\Member;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlanStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_非登入的使用者不能加入店家積點()
    {
        $this->json('POST', 'api/plan')
            ->assertStatus(401);
    }

    public function test_使用者成為店家的積點會員()
    {
        $user = factory(User::class)->create();
        $member = factory(Member::class)->create();

        $this->jsonAs($user, 'POST', 'api/plan', [
            'member_id' => $member->id
        ]);

        $this->assertEquals($member->email, $user->plans->first()->email);
    }
}
