<?php

namespace App\Plan;

use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Redeem
{
    public function generate(User $user, Member $member)
    {
        $name = $user->code . '.png';
        $redeemPath = "images/members/{$member->id}/{$name}";
        $fullPath = public_path("storage/{$redeemPath}");
        
        QrCode::format('png')
            ->size(200)
            ->merge(public_path('storage/'.$member->logo), .1, true)
            ->generate($this->getPointsURL($user), $fullPath);

        return $redeemPath;
    }

    public function getPointsURL($user)
    {
        return config('app.url') . "/redeem/{$user->code}";
    }

}