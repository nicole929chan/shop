<?php

namespace Tests\Feature\Admin\Activity;

use App\Models\Activity;
use App\Models\Member;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ActivityStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_未登入者不能新增優惠活動()
    {
        $this->post(route('activity.store'), [])
            ->assertRedirect(route('login'));
    }

    public function test_非管理者不能夠新增優惠活動()
    {
        $this->actingAs(
            $admin = factory(Member::class)->create(['admin' => false]),
            'web'
        );

        $member = factory(Member::class)->create();
        $activity = factory(Activity::class)->make([
            'member_id' => $member->id,
            'image_path' => $image = UploadedFile::fake()->image('desc.png')
        ]);

        $this->post(route('activity.store'), $activity->toArray())
            ->assertStatus(403);
    }

    public function test_管理者能夠新增店家優惠活動()
    {
        Storage::fake('public');

        $this->actingAsAdmin(
            $admin = factory(Member::class)->create()
        );

        $member = factory(Member::class)->create();
        $activity = factory(Activity::class)->make([
            'member_id' => $member->id,
            'image_path' => $image = UploadedFile::fake()->image('desc.png')
        ]);

        $this->json('POST', route('activity.store'), $activity->toArray());

        $this->assertDatabaseHas('activities', [
            'member_id' => $activity->member_id,
            'points' => $activity->points
        ]);

        Storage::disk('public')->assertExists("images/members/{$member->id}/".$image->hashName());
    }

    public function test_新增優惠活動的店家必填()
    {
        $this->actingAsAdmin();

        $this->storeActivity(['member_id' => null])
            ->assertSessionHasErrors('member_id');
    }

    public function test_新增優惠活動的店家必需存在()
    {
        $this->actingAsAdmin();

        $this->storeActivity(['member_id' => 99])
            ->assertSessionHasErrors('member_id');
    }

    public function test_新增優惠活動的點數必須大於零()
    {
        $this->actingAsAdmin();

        $this->storeActivity(['points' => 0])
            ->assertSessionHasErrors('points');
    }

    public function test_新增優惠活動的內容必填()
    {
        $this->actingAsAdmin();

        $this->storeActivity(['description' => null])
            ->assertSessionHasErrors('description');
    }

    public function test_新增優惠活動開始日期須為日期格式()
    {
        $this->actingAsAdmin();

        $this->storeActivity(['activity_start' => 'foo'])
            ->assertSessionHasErrors('activity_start');
    }

    public function test_新增優惠活動結束日期須為日期格式()
    {
        $this->actingAsAdmin();

        $this->storeActivity(['activity_end' => 'foo'])
            ->assertSessionHasErrors('activity_end');
    }

    public function test_新增優惠活動結束日須大於開始日()
    {
        $this->actingAsAdmin();

        $this->storeActivity([
            'activity_start' => today(),
            'activity_end' => today()->subDay()
        ])->assertSessionHasErrors('activity_end');
    }

    public function test_新增優惠活動的圖片必須上傳()
    {
        $this->actingAsAdmin();

        $this->storeActivity(['image_path' => null])
            ->assertSessionHasErrors('image_path');
    }

    public function test_新增優惠活動上傳檔案須為圖檔()
    {
        $this->actingAsAdmin();

        $this->storeActivity(['image_path' => UploadedFile::fake()->create('foo.pdf')])
            ->assertSessionHasErrors('image_path');
    }

    protected function actingAsAdmin($member = null)
    {
        $member = $member ?: factory(Member::class)->make();
        $member->admin = true;
        $member->save();

        $this->actingAs($member, 'web');
    }

    protected function storeActivity($attributes = [])
    {
        $activity = factory(Activity::class)->make($attributes);

        return $this->post(route('activity.store'), $activity->toArray());
    }
}
