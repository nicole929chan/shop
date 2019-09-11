<?php

namespace App\Plan;

use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Card
{
    protected $manager;

    public function __construct(ImageManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * 製作分享卡
     *
     * @param string $imagePath 使用者上傳的原始圖檔位置
     * @param User $user
     * @param Member $member
     * @return void
     */
    public function generate($imagePath, User $user, Member $member)
    {
        $fullPath = $this->generateQrcode($user);

        $image = $this->manager->make('storage/' . $imagePath);
        $image->resize(375, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->contrast(-35);
        $image->insert($fullPath, 'bottom-right', 10, 13);
        // $image->insert(public_path("storage/{$member->logo}"), 'top-left', 6, 6);
        $image->save('storage/' . $imagePath);

        $this->destroyQrcode($fullPath);
    }

    public function getPointsURL($user)
    {
        return config('app.url') . "/getPoints/{$user->code}";
    }

    public function generateQrcode($user)
    {
        $name = $user->code . '.png';
        QrCode::format('png')
            ->size(110)
            ->generate($this->getPointsURL($user), $fullPath = public_path("storage/images/{$name}"));
        
        return $fullPath;
    }

    public function destroyQrcode($fullPath)
    {
        unlink($fullPath);
    }
}