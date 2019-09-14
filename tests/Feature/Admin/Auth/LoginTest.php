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
        $this->withoutExceptionHandling();
        $member = factory(Member::class)->create();

        $this->post('login', [
            'email' => $member->email,
            'password' => $member->code
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

    public function test_管理員登入後導向所有店家清單頁面()
    {
        $admin = factory(Member::class)->create(['admin' => true]);
        
        $this->post('login', [
            'email' => $admin->email,
            'password' => $admin->code
        ])->assertRedirect(route('manager.index'));
    }

    public function test_店家的登入時效未過期可以再登入()
    {
        $member = factory(Member::class)->create([
            'start_date' => now()->subDay(),
            'finish_date' => now()->addDay()
        ]);

        $this->post('login', [
            'email' => $member->email,
            'password' => $member->code
        ]);

        $this->assertInstanceOf(Member::class, auth()->guard('web')->user());
    }

    public function test_店家的登入時效若過就不能再登入()
    {
        $member = factory(Member::class)->create([
            'start_date' => '2019-01-01',
            'finish_date' => '2019-01-31'
        ]);

        $this->post('login', [
            'email' => $member->email,
            'password' => $member->code
        ]);

        $this->assertNull(auth()->guard('web')->user());
    }
}
