<?php

namespace Tests\Feature\Admin\Member;

use App\Models\Member;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_未登入的店家不能瀏覽資料()
    {
        $this->get('members/1')
            ->assertRedirect(route('login'));
    }

    public function test_登入的店家不能瀏覽其他家的資料()
    {
        $member = factory(Member::class)->create();
        $anotherMember = factory(Member::class)->create();

        $this->actingAs($member, 'web');

        $this->get("members/{$anotherMember->id}")
            ->assertStatus(403);
    }

    public function test_登入的店家能瀏覽資料()
    {
        $member = factory(Member::class)->create();

        $this->actingAs($member, 'web');

        $this->get("members/{$member->id}")
            ->assertSee($member->name);
    }

    public function test_管理者能夠瀏覽其他店家資料()
    {
        $admin = factory(Member::class)->create();
        $admin->admin = true;
        $admin->save();

        $member = factory(Member::class)->create();

        $this->actingAs($admin, 'web');

        $this->get("members/{$member->id}")
            ->assertSee($member->name);
    }
}
