<?php

namespace Tests\Unit\Plan;

use App\Models\Activity;
use App\Models\Member;
use App\Models\User;
use App\Plan\Plan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Mockery;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PlanTest extends TestCase
{
    use RefreshDatabase;

    // public function test_店家的優惠活動計畫被參加()
    // {
    //     $user = factory(User::class)->create();       
    //     $member = factory(Member::class)->create();
    //     $image = UploadedFile::fake()->image('photo.jpg');

    //     $img = Mockery::mock(Image::class);

    //     $manager = $this->mock(ImageManager::class, function ($mock) use ($img) {
    //         $mock->shouldReceive('make')
    //             ->andReturn($img)
    //             ->once();
    //     });

    //     $img->shouldReceive('resize')
    //         ->shouldReceive('contrast')
    //         ->shouldReceive('insert')
    //         ->once();

    //     // $mock = Mockery::mock(ImageManager::class);
    //     // app()->instance(ImageManager::class, $mock);
        
    //     $plan = new Plan($user, $manager);
    //     $plan->add($member->id, $image);

    //     $this->assertEquals($member->id, $user->fresh()->plans->first()->id);

    //     // $mock::shouldReceive('make')->once();
    // }

    // public function test_獲取點數的API網址()
    // {
    //     $user = factory(User::class)->create();

    //     $mock = Mockery::mock(ImageManager::class);
    //     app()->instance(ImageManager::class, $mock);

    //     $plan = new Plan($user, $mock);

    //     $url = config('app.url') . "/getPoints/{$user->id}";

    //     $this->assertEquals($url, $plan->getPointsURL());
    // }

    // public function test_產生獲取點數的QRCode圖檔()
    // {
    //     $user = factory(User::class)->create();

    //     $mock = Mockery::mock(ImageManager::class);
    //     app()->instance(ImageManager::class, $mock);

    //     $memberId = 1;

    //     $plan = new Plan($user, $mock);

    //     QrCode::shouldReceive('format->size->generate')->once();

        
    //     $plan->generateQrcode($path = "images/cards/{$memberId}");
    // }

    // public function test_刪除獲取點數QRcode圖檔()
    // {
    //     $path = UploadedFile::fake()
    //         ->image('qrcode.png')->store('testing/images/cards/1', 'public');

    //     Storage::disk('public')->assertExists($path);
        
    //     $user = factory(User::class)->create();

    //     $mock = Mockery::mock(ImageManager::class);
    //     app()->instance(ImageManager::class, $mock);

    //     $plan = new Plan($user, $mock);

    //     $plan->destroyQrcode($path);

    //     Storage::disk('public')->assertMissing($path);
        
    // }

    // public function test_獲取店家最新優惠活動計畫()
    // {
    //     $user = factory(User::class)->create();
    //     $member = factory(Member::class)->create();
    //     $member->activity()->save(
    //         factory(Activity::class)->create(['description' => 'summer sales'])
    //     );

    //     $plan = new Plan($user);
    //     $activity = $plan->getActivity($member->id);

    //     $this->assertEquals('summer sales', $activity->description);
    // }
}
