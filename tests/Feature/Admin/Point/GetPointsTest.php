<?php

namespace Tests\Feature\Admin\Point;

use App\Models\Member;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetPointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_店家能贈送點數()
    {
        $member= factory(Member::class)->create();
        $user = factory(User::class)->create();
        $member->users()->attach($user, ['card' => 'images/cards/xyz.jpg']);
        
        $this->get(route('getPoints', [$user->code]))
            ->assertStatus(200);

        $this->post('getPoints', [
            'code' => $user->code,
            'member_id' => $member->id,
            'points' => 10
        ]);

        $this->assertDatabaseHas('points', [
            'user_id' => $user->id,
            'member_id' => $member->id,
            'points' => 10
        ]);
    }
}
