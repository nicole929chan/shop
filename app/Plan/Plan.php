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

    public function __construct(User $user, Card $card)
    {
        $this->user = $user;

        $this->card = $card; 
    }

    public function add($memberId, $image)
    {
        $this->member = Member::find($memberId);
        $path = "images/cards/{$memberId}";
        $imagePath = $image->store($path, 'public');

        $this->user->plans()->attach($memberId, ['card' => $imagePath]);

        $this->card->generate($imagePath, $this->user, $this->member);
    }
}