<?php

namespace Tests\Unit\Models;

use App\Models\Activity;
use App\Models\Member;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberTest extends TestCase
{
    use RefreshDatabase;

    public function test_新增店家時一併產生店家二維碼網址()
    {
        $member = factory(Member::class)->create();

        $qrcode = config('app.client_url') . "/members/{$member->id}";

        // dd($qrcode);

        $this->assertEquals($qrcode, $member->fresh()->qrcode);
    }

    public function test_新增店家時一併產生店家代碼()
    {
        $member = factory(Member::class)->create(['code' => '12345']);

        $this->assertNotEquals('12345', $member->fresh()->code);
    }

    public function test_新增店家時一併產生密碼()
    {
        $member = factory(Member::class)->create();

        $this->assertNotEquals($member->fresh()->code, $member->fresh()->password);
    }

    public function test_店家有一筆優惠活動()
    {
        $member = factory(Member::class)->create();
        $activity = factory(Activity::class)->create(['member_id' => $member->id]);

        $this->assertInstanceOf(Activity::class, $member->activity);
    }

    public function test_店家有多位使用者()
    {
        $member = factory(Member::class)->create();
        $user = factory(User::class)->create();
       
        $member->users()->attach($user, ['card' => 'images/cards/xyz.jpg']);

        $this->assertEquals(1, $member->users->count());
    }
}
