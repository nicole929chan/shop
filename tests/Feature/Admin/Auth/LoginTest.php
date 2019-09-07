<?php

namespace Tests\Feature\Admin\Auth;

use App\Models\Member;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_瀏覽店家登入頁面()
    {
        $this->get('login')->assertStatus(200);
    }

    public function test_店家能夠登入()
    {
        $member = factory(Member::class)->create();

        $this->post('login', [
            'email' => $member->email,
            'password' => 'password'
        ])->assertRedirect(route('member.show', ['member' => $member->id]));
    }

    public function test_店家能夠登出()
    {
        $member = factory(Member::class)->create();
        $this->actingAs($member, 'web');

        $this->post('logout')
            ->assertRedirect('/');
            
        $this->assertNull(auth()->guard('web')->user());
    }

    // public function test_管理員登入後導向所有店家清單頁面()
    // {
    //     $admin = factory(Member::class)->create();
    //     $admin->admin = true;
    //     $admin->save();
        
    //     $this->actingAs($admin, 'web');

    //     $this->post('login', [
    //         'email' => $admin->email,
    //         'password' => 'password'
    //     ])->assertRedirect(route('manager.index'));
    // }
}
