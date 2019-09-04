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
