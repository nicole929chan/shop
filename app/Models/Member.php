<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{

    public static function boot()
    {
        parent::boot();

        static::created(function ($member) { 
            $member->qrcode = config('app.url') . "/api/members/{$member->id}";
            $member->save();
        });
    }

    public function activity()
    {
        return $this->hasOne(Activity::class);
    }
    
}
