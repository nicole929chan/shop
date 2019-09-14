<?php

namespace Tests\Feature\Admin\Manager;

use App\Models\Member;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
        $this->actingAsAdmin();
        
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
        $this->actingAsAdmin();

        $member = factory(Member::class)->create();
        
        $request = factory(Member::class)->make()->toArray();
        $request['start_date'] = 'foo';

        $this->patch(route('manager.update', [$member->id]), $request)
            ->assertSessionHasErrors(['start_date']);
    }

    public function test_修改的店家結束日期必填()
    {
        $this->updateManager(['finish_date' => null])->assertSessionHasErrors(['finish_date']);
    }

    public function test_修改的店家結束日期須為日期格式()
    {
        $this->actingAsAdmin();

        $member = factory(Member::class)->create();
        
        $request = factory(Member::class)->make()->toArray();
        $request['finish_date'] = 'foo';

        $this->patch(route('manager.update', [$member->id]), $request)
            ->assertSessionHasErrors(['finish_date']);
    }

    public function test_修改的店家結束日期必需大於啟用日期()
    {
        $this->updateManager([
            'start_date' => '2018-01-03',
            'finish_date' => '2018-01-01'
        ])->assertSessionHasErrors(['finish_date']);
    }

    public function test_修改的店家若上傳新logo則舊的須刪除()
    {
        Storage::fake('public');

        $this->actingAsAdmin();

        $member = factory(Member::class)->create();
        $member->update([
            'logo' => $logo = UploadedFile::fake()->image('logo.png')->store("images/members/{$member->id}", 'public')
        ]);

        $info = factory(Member::class)->make([
            'logo' => $newlogo = UploadedFile::fake()->image('newlogo.png')
        ]);

        $this->patch(route('manager.update', [$member->id]), $info->toArray());

        Storage::disk('public')->assertMissing($logo);
        
        Storage::disk('public')->assertExists("images/members/{$member->id}/".$newlogo->hashName());

        $this->assertDatabaseHas('members', [
            'id' => $member->id,
            'logo' => "images/members/{$member->id}/".$newlogo->hashName()
        ]);
    }

    public function test_修改的店家若上傳新形象圖檔則舊的須刪除()
    {
        $this->withoutExceptionHandling();
        Storage::fake('public');

        $this->actingAsAdmin();

        $member = factory(Member::class)->create();
        $member->update([
            'image' => $image = UploadedFile::fake()->image('image.png')->store("images/members/{$member->id}", 'public')
        ]);

        $info = factory(Member::class)->make([
            'image' => $newimage = UploadedFile::fake()->image('newimage.png')
        ]);

        $this->patch(route('manager.update', [$member->id]), $info->toArray());

        Storage::disk('public')->assertMissing($image);
        
        Storage::disk('public')->assertExists("images/members/{$member->id}/".$newimage->hashName());

        $this->assertDatabaseHas('members', [
            'id' => $member->id,
            'image' => "images/members/{$member->id}/".$newimage->hashName()
        ]);
    }

    protected function actingAsAdmin($member = null)
    {
        $member = $member ?: factory(Member::class)->create(['admin' => true]);

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
