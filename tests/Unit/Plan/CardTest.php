<?php

namespace Tests\Unit\Plan;

use App\Models\Member;
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
    use RefreshDatabase;

    public function test_獲取點數的API網址()
    {
        $user = factory(User::class)->create();
        $manager = new ImageManager();
        $url = config('app.url') . "/getPoints/{$user->code}";

        $card = new Card($manager);

        $this->assertEquals($url, $card->getPointsURL($user));
    }

    public function test_產生獲取點數的QRCode圖檔()
    {
        $user = factory(User::class)->create();
        $manager = new ImageManager();
        
        QrCode::shouldReceive('format->size->generate')->once();
        
        $card = new Card($manager);
        $card->generateQrcode($user);
    }

    public function test_刪除獲取點數QRcode圖檔()
    {
        Storage::fake('public');
        $qrcodePath = UploadedFile::fake()->image('qrcode.png')->store('images/members', 'public');
        
        $user = factory(User::class)->create();
        $manager = new ImageManager();
        
        $fullPath = storage_path('framework/testing/disks/public/'.$qrcodePath);
        
        $card = new Card($manager);
        $card->destroyQrcode($fullPath);

        Storage::disk('public')->assertMissing($qrcodePath);
    }

    public function test_製作分享卡()
    {
        Storage::fake('public');
        
        $user = factory(User::class)->make();
        $member = factory(Member::class)->create();
        $path = 'images/members/' . $member->id;

        $imagePath = UploadedFile::fake()->image('user.png')->store($path, 'public');
        
        $image = Mockery::mock(Image::class);
        app()->instance(Image::class, $image);
   
        $manager = $this->mock(ImageManager::class, function ($mock) use ($image) {
            $mock->shouldReceive('make')
                ->andReturn($image)
                ->once();
        });

        $image->shouldReceive('resize')
            ->shouldReceive('contrast')->with(-35)
            ->shouldReceive('insert')
            ->shouldReceive('save');
        
        $card = new Card($manager);

        $card->generate($imagePath, $user, $member);
    }
}
