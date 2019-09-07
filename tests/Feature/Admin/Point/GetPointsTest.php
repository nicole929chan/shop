<?php

namespace Tests\Feature\Admin\Point;

use App\Models\Activity;
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
        $member->activity()->save(
            $activity = factory(Activity::class)->create()
        );
        $member->users()->attach($user, ['card' => 'images/cards/xyz.jpg']);
        
        $this->get(route('getPoints', [$user->code]))
            ->assertStatus(200);

        $this->post('getPoints', [
            'user_code' => $user->code,
            'member_code' => $member->code,
            'points' => 10
        ]);

        $this->assertDatabaseHas('points', [
            'user_id' => $user->id,
            'member_id' => $member->id,
            'points' => 10
        ]);
    }

    public function test_贈送點數的使用者代碼必填()
    {
        $this->storePoints('user_code', null)
            ->assertSessionHasErrors(['user_code']);
    }

    public function test_贈送點數的使用者代碼必需存在()
    {
        $this->storePoints('user_code', '99999')
            ->assertSessionHasErrors(['user_code']);
    }

    public function test_贈送點數的店家代碼必填()
    {
        $this->storePoints('member_code', null)
            ->assertSessionHasErrors(['member_code']);
    }

    public function test_贈送點數的店家代碼必需存在()
    {
        $this->storePoints('member_code', '99999')
            ->assertSessionHasErrors(['member_code']);
    }

    public function test_贈送的點數必須大於零()
    {
        $this->storePoints('points', 0)
            ->assertSessionHasErrors(['points']);
    }

    public function test_使用者必須有加入該店家才能贈與點數()
    {
        $user = factory(User::class)->create();
        $member = factory(Member::class)->create();
        $member->activity()->save(
            $activity = factory(Activity::class)->create()
        );

        $this->post('getPoints', [
            'user_code' => $user->code,
            'member_code' => $member->code,
            'points' => 10
        ])->assertSessionHasErrors('user_code');
    }

    public function test_店家的活動期間須有效才能贈點()
    {
        $member = factory(Member::class)->create();
        $user = factory(User::class)->create();
        $member->activity()->save(
            $activity = factory(Activity::class)->create([
                'activity_start' => '2019-01-01',
                'activity_end' => '2019-01-02'
            ])
        );
        $member->users()->attach($user, ['card' => 'images/cards/xyz.jpg']);

        $this->post('getPoints', [
            'user_code' => $user->code,
            'member_code' => $member->code,
            'points' => 10
        ])->assertSessionHasErrors('member_code');
    }

    protected function storePoints($key, $value)
    {
        $attributes = [
            'user_code' => '12587',
            'member_code' => '96325',
            'points' => 10
        ];

        $attributes[$key] = $value;

        return $this->post('getPoints', $attributes);
    }
}
