<?php

namespace Tests\Feature\Admin\Manager;

use App\Models\Member;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagerIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_未登入者不能瀏覽所有店家()
    {
        $this->get('manager')->assertRedirect(route('login'));
    }

    public function test_非管理員不能瀏覽所有店家()
    {
        $member = factory(Member::class)->create();
        $member->admin = false;
        $member->save();

        $this->actingAs($member, 'web');

        $this->get('manager')->assertStatus(403);
    }

    public function test_管理員能夠瀏覽所有店家()
    {
        $this->actingAsAdmin();

        $this->get('manager')->assertStatus(200);
    }

    public function test_瀏覽的店家以姓名排序()
    {
        $admin = factory(Member::class)->create(['name' => 'Admin']);
        $john = factory(Member::class)->create(['name' => 'John']);
        $bear = factory(Member::class)->create(['name' => 'Bear']);

        $this->actingAsAdmin($admin);

        $response = $this->json('GET', 'manager')->json();

        $this->assertEquals(['Admin', 'Bear', 'John'], array_column($response['data'], 'name'));
    }

    protected function actingAsAdmin($member = null)
    {
        $member = $member ?: factory(Member::class)->create();
        $member->admin = true;
        $member->save();

        $this->actingAs($member, 'web');
    }
}
