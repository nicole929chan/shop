<?php

namespace App\Plan;

use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use QrCode;

class Plan
{
    protected $member;

    protected $user;

    protected $card;
    
    protected $redeem;

    public function __construct(User $user, Card $card, Redeem $redeem)
    {
        $this->user = $user;

        $this->card = $card;
        
        $this->redeem = $redeem;
    }

    public function add($memberId, $image)
    {
        $this->member = Member::find($memberId);
        $path = "images/members/{$memberId}/cards";
        $imagePath = $image->store($path, 'public');

        $this->card->generate($imagePath, $this->user, $this->member);
        
        $redeemPath = $this->redeem->generate($this->user, $this->member);
        
        $this->user->plans()->attach($memberId, [
            'card' => $imagePath,
            'redeem' => $redeemPath
        ]);
    }
}