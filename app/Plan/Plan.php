<?php

namespace App\Plan;

use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use QrCode;

class Plan
{
    protected $user;

    protected $manager;

    public function __construct(User $user, ImageManager $manager)
    {
        $this->user = $user;

        $this->manager = $manager;
    }

    public function add($memberId, $image)
    {
        $path = "images/cards/{$memberId}";
        $card = $image->store($path, 'public');

        $this->user->plans()->attach($memberId, ['card' => $card]);

        $qrcodePath = "$path/{$this->user->id}.png";
        $this->generateQrcode($qrcodeFullPath = public_path("storage/{$qrcodePath}"));

        $activity = $this->getActivity($memberId);

        $this->generateCard($card, $qrcodeFullPath, $activity);
        
        $this->destroyQrcode($qrcodePath);
    }

    public function generateCard($card, $qrcodeFullPath, $activity)
    {
        $img = $this->manager->make('storage/' . $card);
        $img->resize(375, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->contrast(-35);
        $img->insert($qrcodeFullPath, 'center');
        $img->text($activity->member->name, 20, 30, function($font) {
            $font->color('#ffffff');
            $font->size(20);
            $font->file(public_path('storage/fonts/raleway/Raleway-Bold.ttf'));
        });
        $img->save('storage/' . $card);
    }

    public function getPointsURL()
    {
        return config('app.url') . "/getPoints/{$this->user->id}";
    }

    public function getActivity($memberId)
    {
        $member = Member::find($memberId);        

        return $member->activity;
    }

    public function generateQrcode($qrcodeFullPath)
    {
        QrCode::format('png')
            ->size(110)
            ->generate($this->getPointsURL(), $qrcodeFullPath);
    }

    public function destroyQrcode($qrcodePath)
    {
        Storage::disk('public')->delete($qrcodePath);
    }
}