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
        $this->withoutExceptionHandling();

        $this->actingAsAdmin($admin = factory(Member::class)->create());
        
        $member = factory(Member::class)->create();

        $this->get(route('manager.edit', [$member->id]))
            ->assertStatus(200);

        $info = factory(Member::class)->make();

        $this->patch(route('manager.update', [$member->id]), $info->toArray());

        $this->assertDatabaseHas('members', [
            'id' => $member->id,
            'email' => $info->email,
            'phone_number' => $info->phone_number
        ]);
    }

    public function test_修改店家的姓名必填()
    {
        $this->updateManager(['name' => null])->assertSessionHasErrors('name');
    }

    public function test_修改店家的郵件必填()
    {
        $this->updateManager(['email' => null])->assertSessionHasErrors('email');
    }

    public function test_修改的店家郵件格式需正確()
    {
        $this->updateManager(['email' => 'foo@'])->assertSessionHasErrors(['email']);
    }

    public function test_修改店家的郵件不可與現有的重複()
    {
        $member = factory(Member::class)->create();

        $this->updateManager(['email' => $member->email])->assertSessionHasErrors('email');
    }

    public function test_修改店家的電話必填()
    {
        $this->updateManager(['phone_number' => null])->assertSessionHasErrors('phone_number');
    }

    public function test_修改店家的地址必填()
    {
        $this->updateManager(['address' => null])->assertSessionHasErrors('address');
    }

    public function test_修改的店家啟用日期必填()
    {
        $this->updateManager(['start_date' => null])->assertSessionHasErrors(['start_date']);
    }

    public function test_修改的店家啟用日期須為日期格式()
    {
        $this->updateManager(['start_date' => 'foo'])->assertSessionHasErrors(['start_date']);
    }

    public function test_修改的店家結束日期必填()
    {
        $this->updateManager(['finish_date' => null])->assertSessionHasErrors(['finish_date']);
    }

    public function test_修改的店家結束日期須為日期格式()
    {
        $this->updateManager(['finish_date' => 'foo'])->assertSessionHasErrors(['finish_date']);
    }

    public function test_修改的店家結束日期必需大於啟用日期()
    {
        $this->updateManager([
            'start_date' => '2018-01-03',
            'finish_date' => '2018-01-01'
        ])->assertSessionHasErrors(['finish_date']);
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

    protected function updateManager($attributes = [])
    {
        $this->actingAsAdmin();

        $member = factory(Member::class)->create();
        $info = factory(Member::class)->make($attributes);

        return $this->patch(route('manager.update', [$member->id]), $info->toArray());
    }
}
