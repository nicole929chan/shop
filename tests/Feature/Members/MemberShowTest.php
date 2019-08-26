<?php

namespace Tests\Feature\Members;

use App\Models\Activity;
use App\Models\Member;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_使用者能夠瀏覽單一店家資訊()
    {
        $this->withoutExceptionHandling();
        $member = factory(Member::class)->create();

        $this->json('GET', "api/members/{$member->id}")
            ->assertJsonFragment([
                'name' => $member->name
            ]);
    }

    public function test_瀏覽的店家其優惠一併顯示()
    {
        $member = factory(Member::class)->create();
        $member->activity()->save(
            $activity = factory(Activity::class)->make()
        );

        $this->json('GET', "api/members/{$member->id}")
            ->assertJsonStructure([
                'data' => [
                    'activity'
                ]
            ]);
    }

    public function test_瀏覽店家的優惠效期需標記()
    {
        $member = factory(Member::class)->create();
        $member->activity()->save(
            $activity = factory(Activity::class)->make()
        );

        $this->json('GET', "api/members/{$member->id}")
            ->assertJsonStructure([
                'meta' => [
                    'valid'
                ]
            ]);
    }
}
