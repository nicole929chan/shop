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
        $activity = factory(Activity::class)->create(['member_id' => $member->id]);

        $this->assertEquals($member->id, $activity->member->id);
    }
}
