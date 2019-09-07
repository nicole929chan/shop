<?php

namespace Tests\Unit\Models;

use App\Models\Activity;
use App\Models\Member;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    public function test_一筆優惠活動屬於一位店家()
    {
        $member = factory(Member::class)->create();
        $activity = factory(Activity::class)->make(['member_id' => $member->id]);

        $this->assertEquals($member->id, $activity->member->id);
    }

    public function test_優惠活動的結束時間自動加到凌晨()
    {
        $activity = factory(Activity::class)->create(['activity_end' => '2019-12-25']);

        $this->assertEquals('2019-12-25 23:59:59', $activity->fresh()->activity_end);
    }

    public function test_判斷優惠活動的有效性()
    {
        $activity = factory(Activity::class)->make([
            'activity_start' => now()->subDay(1),
            'activity_end' => now()->addDay(1),
        ]);

        $this->assertTrue($activity->getValid());
    }

    public function test_判斷優惠活動的無效性()
    {
        $activity = factory(Activity::class)->make([
            'activity_start' => now()->subDay(3),
            'activity_end' => now()->subDay(1),
        ]);

        $this->assertFalse($activity->getValid());
    }

    public function test_判斷優惠活動尚未生效()
    {
        $activity = factory(Activity::class)->make([
            'activity_start' => now()->addDay(1),
            'activity_end' => now()->addDays(3),
        ]);

        $this->assertFalse($activity->getValid());
    }
}
