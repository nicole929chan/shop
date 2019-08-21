<?php

namespace Tests\Unit\Plan;

use App\Models\Activity;
use App\Models\Member;
use App\Models\User;
use App\Plan\Plan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

class PlanTest extends TestCase
{
    use RefreshDatabase;

    public function test_店家的優惠活動計畫被參加()
    {
        $user = factory(User::class)->create();
        $member = factory(Member::class)->create();
        $image = UploadedFile::fake()->image('photo.jpg');
        
        $plan = new Plan($user);
        $plan->add($member->id, $image);

        $this->assertEquals($member->id, $user->fresh()->plans->first()->id);
    }

    public function test_獲取店家最新優惠活動計畫()
    {
        $user = factory(User::class)->create();
        $member = factory(Member::class)->create();
        $member->activity()->save(
            factory(Activity::class)->create(['description' => 'summer sales'])
        );

        $plan = new Plan($user);
        $activity = $plan->getActivity($member->id);

        $this->assertEquals('summer sales', $activity->description);
    }
}
