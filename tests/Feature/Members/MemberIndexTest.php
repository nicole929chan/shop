<?php

namespace Tests\Feature\Members;

use App\Models\Activity;
use App\Models\Member;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_使用者能夠瀏覽所有店家()
    {
        $members = factory(Member::class, 2)->create();

        $response = $this->json('GET', 'api/members');

        $members->each(function ($member) use ($response) {
            $response->assertJsonFragment(['name' => $member->name]);
        });
    }

    // public function test_使用者瀏覽的店家其優惠期間是有效的()
    // {
    //     $members = factory(Member::class)->create();
    //     $member->activity()->save(
    //         factory(Activity::class)->create([
    //             'activity_start' => 
    //         ]);
    //     );
    // }
}
