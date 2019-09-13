<?php

namespace Tests\Feature\Admin\Manager;

use App\Models\Member;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ManagerStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_未登入者不能新增店家()
    {
        $this->post('manager', [])->assertRedirect(route('login'));
    }

    public function test_非管理員不能夠新增店家()
    {
        $this->actingAs(
            $admin = factory(Member::class)->create(['admin' => false]),
            'web'
        );

        $this->get(route('manager.create'))->assertStatus(403);

        $member = factory(Member::class)->create();
        
        $this->post('manager', $member->toArray())
            ->assertStatus(403);
    }

    public function test_管理員能夠新增店家()
    {
        Storage::fake('public');

        $this->actingAsAdmin($admin = factory(Member::class)->create());
        
        $member = factory(Member::class)->make([
            'logo' => $logo =UploadedFile::fake()->image('logo.png'),
            'image' => $image =UploadedFile::fake()->image('image.png'),
        ]);
        $member->admin = false;

        $this->post('manager', $member->toArray());

        $this->assertDatabaseHas('members', [
            'email' => $member->email
        ]);

        $member = Member::whereEmail($member->email)->first();

        Storage::disk('public')->assertExists("images/members/{$member->id}/".$logo->hashName());
        Storage::disk('public')->assertExists("images/members/{$member->id}/".$image->hashName());
    }

    public function test_新增的店家姓名必填()
    {
        $this->storeManager(['name' => null])->assertSessionHasErrors(['name']);
    }

    public function test_新增的店家電話必填()
    {
        $this->storeManager(['phone_number' => null])->assertSessionHasErrors(['phone_number']);
    }

    public function test_新增的店家地址必填()
    {
        $this->storeManager(['address' => null])->assertSessionHasErrors(['address']);
    }

    public function test_新增的店家郵件必填()
    {
        $this->storeManager(['email' => null])->assertSessionHasErrors(['email']);
    }

    public function test_新增的店家郵件格式需正確()
    {
        $this->storeManager(['email' => 'foo@'])->assertSessionHasErrors(['email']);
    }

    public function test_新增的店家啟用日期必填()
    {
        $this->storeManager(['start_date' => null])->assertSessionHasErrors(['start_date']);
    }

    public function test_新增的店家啟用日期須為日期格式()
    {
        $this->actingAsAdmin();

        $member = factory(Member::class)->make()->toArray();
        $member['start_date'] = 'foo';

        $this->post('manager', $member)
            ->assertSessionHasErrors(['start_date']);
    }

    public function test_新增的店家結束日期必填()
    {
        $this->storeManager(['finish_date' => null])->assertSessionHasErrors(['finish_date']);
    }

    public function test_新增的店家結束日期須為日期格式()
    {
        $this->actingAsAdmin();

        $member = factory(Member::class)->make()->toArray();
        $member['finish_date'] = 'foo';

        $this->post('manager', $member)
            ->assertSessionHasErrors(['finish_date']);
    }

    public function test_新增的店家結束日期必需大於啟用日期()
    {
        $this->storeManager([
            'start_date' => '2018-01-03',
            'finish_date' => '2018-01-01'
        ])->assertSessionHasErrors(['finish_date']);
    }

    public function test_新增的店家若沒上傳logo改用平台預設的()
    {
        Storage::fake('public');

        $this->actingAsAdmin($admin = factory(Member::class)->create());
        
        $member = factory(Member::class)->make([
            'logo' => null,
            'image' => $image = UploadedFile::fake()->image('image.png')
        ]);
        $member->admin = false;

        $this->post('manager', $member->toArray());

        $this->assertDatabaseHas('members', [
            'email' => $member->email,
            'logo' => 'images/logo.jpg'
        ]);
    }

    public function test_新增的店家其形象圖檔必填()
    {
        $this->storeManager([
            'admin' => 0,
            'image' => null
        ])->assertSessionHasErrors(['image']);
    }

    public function test_新增的店家若為管理者其形象圖檔不必上傳()
    {
        $this->storeManager([
            'admin' => 1,
            'image' => null
        ])->assertSessionDoesntHaveErrors('image');
    }

    protected function actingAsAdmin($member = null)
    {
        $member = $member ?: factory(Member::class)->create();
        $member->admin = true;
        $member->save();

        $this->actingAs($member, 'web');
    }

    protected function storeManager($attributes = [])
    {
        $this->actingAsAdmin();

        $member = factory(Member::class)->make($attributes);

        return $this->post('manager', $member->toArray());
    }
}
