<?php

namespace Tests\Feature\Members;

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
}
