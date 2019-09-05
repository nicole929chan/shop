<?php

namespace Tests\Feature\Admin\Activity;

use App\Models\Activity;
use App\Models\Member;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_管理者能夠新增店家優惠活動()
    {
        // $this->actingAsAdmin(
        //     $admin = factory(Member::class)->create()
        // );

        // $member = factory(Member::class)->create();
        // $activity = factory(Activity::class)->make(['member_id' => $member->id]);


    }

    protected function actingAsAdmin($member = null)
    {
        $member = $member ?: factory(Member::class)->create();
        $member->admin = true;
        $member->save();

        $this->actingAs($member, 'web');
    }
}
