<?php

namespace Tests\Unit\Models;

use App\Models\Activity;
use App\Models\Member;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberTest extends TestCase
{
    use RefreshDatabase;

    public function test_新增店家時一併產生店家二維碼網址()
    {
        $member = factory(Member::class)->create();

        $qrcode = config('app.url') . "/api/members/{$member->id}";

        $this->assertEquals($qrcode, $member->fresh()->qrcode);
    }

    public function test_店家有一筆優惠活動()
    {
        $member = factory(Member::class)->create();
        $activity = factory(Activity::class)->create(['member_id' => $member->id]);

        $this->assertInstanceOf(Activity::class, $member->activity);
    }
}
