<?php

namespace Tests\Feature\Admin\Member;

use App\Models\Member;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_未登入的店家不能瀏覽客戶()
    {
        $memberId = 1;

        $this->get(route('user.index', [$memberId]))
            ->assertRedirect(route('login'));
    }

    public function test_店家僅能瀏覽自己的客戶()
    {
        $member = factory(Member::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($member, 'web');

        $this->get(route('user.index', [$member->id]))
            ->assertDontSee($user->name);
    }

    public function test_店家能夠瀏覽客戶()
    {
        $member = factory(Member::class)->create();
        $user = factory(User::class)->create();
       
        $member->users()->attach($user, ['card' => 'images/cards/xyz.jpg']);

        $this->actingAs($member, 'web');

        $this->get(route('user.index', [$member->id]))
            ->assertSee($user->name);
    }

    public function test_瀏覽的客戶依姓名排列()
    {
        $member = factory(Member::class)->create();
        $john = factory(User::class)->create(['name' => 'john']);
        $alex = factory(User::class)->create(['name' => 'alex']);
       
        $member->users()->attach($john, ['card' => 'images/cards/john.jpg']);
        $member->users()->attach($alex, ['card' => 'images/cards/alex.jpg']);

        $this->actingAs($member, 'web');

        $response = $this->json('GET', route('user.index', [$member->id]))->json();

        $this->assertEquals(['alex', 'john'], array_column($response, 'name'));
    }
}
