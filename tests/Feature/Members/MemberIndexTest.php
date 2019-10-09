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

    public function test_使用者瀏覽的店家排除管理者()
    {
        $admin = factory(Member::class)->create();
        $admin->admin = true;
        $admin->save();

        $member = factory(Member::class)->create();

        $response = $this->json('GET', 'api/members');

        $response->assertJsonMissing(['name' => $admin->name]);
    }

    public function test_瀏覽的店家須依建檔日期遞減排序()
    {
        $member = factory(Member::class)->create();
        $member2 = factory(Member::class)->create(['created_at' => today()->addDay()]);
        
        $response = $this->json('GET', 'api/members');

        $members = $response->json();

        $this->assertEquals([
            $member2->name,
            $member->name
        ], array_column($members['data'], 'name'));
    }
}
