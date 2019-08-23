<?php

namespace Tests\Feature\Members;

use App\Models\Member;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_使用者能夠瀏覽單一店家資訊()
    {
        $member = factory(Member::class)->create();

        $this->json('GET', "api/members/{$member->id}")
            ->assertJsonFragment([
                'name' => $member->name
            ]);
    }
}
