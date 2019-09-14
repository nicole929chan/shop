<?php

namespace Tests\Feature\Admin\Activity;

use App\Models\Activity;
use App\Models\Member;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ActivityUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_未登入者不能夠異動優惠活動()
    {
        $this->patch(route('activity.update', [1]))
            ->assertRedirect(route('login'));
    }

    public function test_非管理者不能夠異動優惠活動()
    {
        $member = factory(Member::class)->create(['admin' => false]);
        $this->actingAs($member, 'web');

        $activity = factory(Activity::class)->create();

        $this->patch(route('activity.update', [$activity->id]), [])
            ->assertStatus(403);
    }

    public function test_管理者能夠異動優惠活動()
    {
        $this->actingAsAdmin();

        $activity = factory(Activity::class)->create();

        $this->patch(route('activity.update', [$activity->id]), [
            'points' => 7,
            'description' => 'new description',
            'activity_start' => '2019-01-01',
            'activity_end' => '2019-03-31'
        ]);

        $this->assertDatabaseHas('activities', [
            'points' => 7,
            'description' => 'new description'
        ]);
    }

    public function test_異動的優惠活動若沒有上傳新圖檔則保留原始活動圖檔()
    {
        Storage::fake('public');

        $member = factory(Member::class)->create();
        $activity = factory(Activity::class)->create([
            'member_id' => $member->id,
            'image_path' => $image_path =  UploadedFile::fake()->image('foo.png')->store("images/members/{$member->id}", 'public')
        ]);

        $this->actingAsAdmin();

        $this->patch(route('activity.update', [$activity->id]), [
            'points' => 7,
            'description' => 'new description',
            'activity_start' => '2019-01-01',
            'activity_end' => '2019-03-31'
        ]);

        Storage::disk('public')->assertExists($image_path);
    }

    public function test_異動的優惠活動若上傳新圖檔則刪除原始活動圖檔()
    {
        Storage::fake('public');

        $member = factory(Member::class)->create();
        $activity = factory(Activity::class)->create([
            'member_id' => $member->id,
            'image_path' => $image_path =  UploadedFile::fake()->image('foo.png')->store("images/members/{$member->id}", 'public')
        ]);

        Storage::disk('public')->assertExists($image_path);

        $this->actingAsAdmin();

        $this->patch(route('activity.update', [$activity->id]), [
            'points' => 7,
            'description' => 'new description',
            'activity_start' => '2019-01-01',
            'activity_end' => '2019-03-31',
            'image_path' => $image =  UploadedFile::fake()->image('bar.png')
        ]);

        Storage::disk('public')->assertMissing($image_path);

        Storage::disk('public')->assertExists("images/members/{$member->id}/{$image->hashName()}");
    }

    public function test_異動的優惠活動贈與點數必須大於零()
    {
        $this->actingAsAdmin();

        $this->updateActivity(['points' => 0])->assertSessionHasErrors('points');
    }

    public function test_異動的優惠活動內容必填()
    {
        $this->actingAsAdmin();

        $this->updateActivity(['description' => null])->assertSessionHasErrors('description');
    }

    public function test_異動的優惠活動開始日期須為日期格式()
    {
        $this->actingAsAdmin();

        $activity = factory(Activity::class)->create();
        
        $request = factory(Activity::class)->make()->toArray();
        $request['activity_start'] = 'foo';

        $this->patch(route('activity.update', [$activity->id]), $request)
            ->assertSessionHasErrors(['activity_start']);
    }

    public function test_異動的優惠活動結束日期須為日期格式()
    {
        $this->actingAsAdmin();

        $activity = factory(Activity::class)->create();
        
        $request = factory(Activity::class)->make()->toArray();
        $request['activity_end'] = 'foo';

        $this->patch(route('activity.update', [$activity->id]), $request)
            ->assertSessionHasErrors(['activity_end']);
    }

    public function test_異動的優惠活動結束日期須大於開始日期()
    {
        $this->actingAsAdmin();

        $this->updateActivity([
            'activity_start' => today()->addDay(),
            'activity_end' => today()
        ])->assertSessionHasErrors('activity_end');
    }

    protected function updateActivity($attributes = [])
    {
        $activity = factory(Activity::class)->create();

        return $this->patch(route('activity.update', [$activity->id]), 
            factory(Activity::class)->make($attributes)->toArray()
        );
    }

    protected function actingAsAdmin($member = null)
    {
        $member = $member ?: factory(Member::class)->make();
        $member->admin = true;
        $member->save();

        $this->actingAs($member, 'web');
    }
}
