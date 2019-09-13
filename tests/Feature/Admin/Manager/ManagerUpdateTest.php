<?php

namespace Tests\Feature\Admin\Manager;

use App\Models\Member;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagerUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_未登入者不能修改店家()
    {
        $this->patch('manager/1', [])->assertRedirect(route('login'));
    }

    public function test_非管理員不能夠修改店家()
    {
        $this->actingAs(
            $admin = factory(Member::class)->create(['admin' => false]),
            'web'
        );

        $member = factory(Member::class)->create();
        
        $this->patch(route('manager.update', [$member->id]), [])
            ->assertStatus(403);
    }

    public function test_管理者能夠修改店家基本資料()
    {
        $this->actingAsAdmin($admin = factory(Member::class)->create());
        
        $member = factory(Member::class)->create();

        $info = factory(Member::class)->make();

        $this->patch(route('manager.update', [$member->id]), $info->toArray());

        $this->assertDatabaseHas('members', [
            'id' => $member->id,
            'email' => $info->email,
            'phone_number' => $info->phone_number
        ]);
    }

    // public function test_修改的店家若()
    // {
        
    // }

    protected function actingAsAdmin($member = null)
    {
        $member = $member ?: factory(Member::class)->create();
        $member->admin = true;
        $member->save();

        $this->actingAs($member, 'web');
    }
}
