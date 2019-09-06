<?php

namespace Tests\Feature\Admin\Manager;

use App\Models\Activity;
use App\Models\Member;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagerShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_未登入者不能夠瀏覽單一店家()
    {
        $this->get(route('manager.show', [1]))->assertRedirect(route('login'));
    }

    public function test_非管理者不能夠瀏覽單一店家()
    {
        $member = factory(Member::class)->create();
        $member->admin = false;
        $member->save();

        $this->actingAs($member, 'web');

        $this->get(route('manager.show', [$member->id]))->assertStatus(403);
    }

    public function test_管理者能夠瀏覽單一店家()
    {
        $this->actingAsAdmin(
            $admin = factory(Member::class)->create()
        );

        $member = factory(Member::class)->create();

        $this->get(route('manager.show', [$member->id]))
            ->assertSee($member->name);
    }

    protected function actingAsAdmin($member = null)
    {
        $member = $member ?: factory(Member::class)->create();
        $member->admin = true;
        $member->save();

        $this->actingAs($member, 'web');
    }
}
