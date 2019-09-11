<?php

namespace Tests\Feature\Admin\Redeem;

use App\Models\Member;
use App\Models\Point;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RedeemTest extends TestCase
{
    use RefreshDatabase;

    public function test_店家能夠兌換()
    {
        $user = factory(User::class)->create();

        $this->get(route('redeem', [$user->code]))->assertStatus(200);

        $member= factory(Member::class)->create();
        $user->plans()->attach($member);
        factory(Point::class)->create([
            'user_id' => $user->id,
            'member_id' => $member->id,
            'points' => 1
        ]);

        $this->post('redeem', [
            'user_code' => $user->code,
            'member_code' => $member->code,
            'points' => 1
        ]);

        $this->assertDatabaseHas('points', [
            'user_id' => $user->id,
            'member_id' => $member->id,
            'points' => -1
        ]);
    }

    public function test_兌換的使用者代碼必填()
    {
        $this->storeRedeem('user_code', null)
            ->assertSessionHasErrors(['user_code']);
    }

    public function test_兌換的使用者代碼必需存在()
    {
        $this->storeRedeem('user_code', '99999')
            ->assertSessionHasErrors(['user_code']);
    }

    public function test_兌換的店家代碼必填()
    {
        $this->storeRedeem('member_code', null)
            ->assertSessionHasErrors(['member_code']);
    }

    public function test_兌換的店家代碼必需存在()
    {
        $this->storeRedeem('member_code', '99999')
            ->assertSessionHasErrors(['member_code']);
    }

    public function test_兌換的點數必須大於零()
    {
        $this->storeRedeem('points', 0)
            ->assertSessionHasErrors(['points']);
    }

    public function test_使用者必須有加入該店家才能兌換()
    {
        $user = factory(User::class)->create();
        $memberNotJoin = factory(Member::class)->create();

        $this->post('redeem', [
            'user_code' => $user->code,
            'member_code' => $memberNotJoin->code,
            'points' => 10
        ])->assertSessionHasErrors('user_code');
    }

    public function test_使用者剩餘點數夠才能兌換()
    {
        $member = factory(Member::class)->create();
        $user = factory(User::class)->create();
        $user->plans()->attach($member);
        
        $points = factory(Point::class)->create([
            'user_id' => $user->id,
            'member_id' => $member->id,
            'points' => 2
        ]);

        $this->post('redeem', [
            'user_code' => $user->code,
            'member_code' => $member->code,
            'points' => 3
        ])->assertSessionHasErrors('user_code');
    }

    protected function storeRedeem($key, $value)
    {
        $attributes = [
            'user_code' => '12587',
            'member_code' => '96325',
            'points' => 1
        ];

        $attributes[$key] = $value;

        return $this->post('redeem', $attributes);
    }
}
