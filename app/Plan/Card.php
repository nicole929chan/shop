<?php

namespace App\Plan;

use App\Models\Member;
use App\Models\User;
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

    public function generate($imagePath, User $user, Member $member)
    {
        $qrcodePath = $this->generateQrcode($user);

        $image = $this->manager->make('storage/' . $imagePath);
        $image->resize(375, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->contrast(-15);
        $image->insert($qrcodePath, 'bottom-right', 10, 13);
        // $image->insert(public_path("storage/{$member->logo}"), 'top-left', 6, 6);
        $image->save('storage/' . $imagePath);

        $this->destroyQrcode($qrcodePath);
    }

    public function getPointsURL($user)
    {
        return config('app.url') . "/getPoints/{$user->id}";
    }

    public function generateQrcode($user)
    {
        $name = $user->id . '.png';
        QrCode::format('png')
            ->size(110)
            ->generate($this->getPointsURL($user), $qrcodePath = public_path("storage/images/{$name}"));

        return $qrcodePath;
    }

    public function destroyQrcode($qrcodePath)
    {
        unlink($qrcodePath);
    }
}