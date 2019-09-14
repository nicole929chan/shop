<?php

namespace Tests\Feature\Admin\Password;

use App\Models\Member;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChangePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_非登入者不能夠修改密碼()
    {
        $this->get('change-password/1')->assertRedirect(route('login'));

        $this->patch('change-password/1', [])->assertRedirect(route('login'));
    }

    public function test_店家只能修改自己的密碼()
    {
        $member = factory(Member::class)->create();
        $another = factory(Member::class)->create();
        
        $this->actingAs($member, 'web');

        $this->get('change-password/'.$another->id)->assertStatus(403);

        $this->patch(route('password.change', [$another->id]), [
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ])->assertStatus(403);
    }

    public function test_店家能夠修改密碼()
    {
        $member = factory(Member::class)->create();
        $old_password = $member->password;

        $this->actingAs($member, 'web');

        $this->get(route('show.change.form', [$member->id]))
            ->assertStatus(200);

        $this->patch(route('password.change', [$member->id]), [
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $this->assertNotEquals($old_password, $member->fresh()->password);
    }

    public function test_管理者能夠修改店家密碼()
    {
        $admin = factory(Member::class)->create(['admin' => true]);
        $member = factory(Member::class)->create();
        $old_password = $member->password;

        $this->actingAs($admin, 'web');

        $this->get(route('show.change.form', [$member->id]))
            ->assertStatus(200);

        $this->patch(route('password.change', [$member->id]), [
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $this->assertNotEquals($old_password, $member->fresh()->password);
    }
}
