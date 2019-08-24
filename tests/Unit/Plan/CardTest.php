<?php

namespace Tests\Unit\Plan;

use App\Models\User;
use App\Plan\Card;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Mockery;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CardTest extends TestCase
{
    // use RefreshDatabase;

    // public function test_獲取點數的API網址()
    // {
    //     $user = factory(User::class)->create();
    //     $manager = new ImageManager();
    //     $url = config('app.url') . "/getPoints/{$user->id}";

    //     $card = new Card($manager);

    //     $this->assertEquals($url, $card->getPointsURL($user));
    // }

    // public function test_產生獲取點數的QRCode圖檔()
    // {
    //     $user = factory(User::class)->create();
    //     $manager = new ImageManager();
        
    //     QrCode::shouldReceive('format->size->generate')->once();
        
    //     $card = new Card($manager);
    //     $card->generateQrcode($user);
    // }

    // public function test_刪除獲取點數QRcode圖檔()
    // {
    //     Storage::fake('public');
    //     Storage::disk('public')->put('qrcode.png', 'qrcode contents');
        
    //     Storage::disk('public')->assertExists('qrcode.png');
        
    //     $testingPath = Storage::disk('public')->getAdapter()->getPathPrefix();
   
    //     $user = factory(User::class)->create();
    //     $manager = new ImageManager();
        
    //     $card = new Card($manager);
    //     $card->destroyQrcode($testingPath . '/qrcode.png');

    //     Storage::disk('public')->assertMissing('qrcode.png');
    // }

    // public function test_製作分享卡()
    // {
    //     Storage::fake('public');
    //     Storage::disk('public')->put('user.png', 'user contents');
        
    //     Storage::disk('public')->assertExists('user.png');

    //     $testingPath = Storage::disk('public')->getAdapter()->getPathPrefix();

    //     $image = Mockery::mock(Image::class);
    //     app()->instance(Image::class, $image);
   
    //     $manager = $this->mock(ImageManager::class, function ($mock) use ($image) {
    //         $mock->shouldReceive('make')
    //             ->andReturn($image)
    //             ->once();
    //     });

    //     $image->shouldReceive('resize')
    //         ->shouldReceive('contrast')->with(-35)
    //         ->shouldReceive('insert')
    //         ->once();
        
    //     $user = factory(User::class)->create();
        
    //     $card = new Card($manager);

    //     $card->generate('user.png', $user);
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
