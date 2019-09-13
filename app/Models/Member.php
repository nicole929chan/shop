<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'code', 'phone_number', 'address', 'qrcode', 'email', 'password', 'start_date', 'finish_date', 'logo', 'admin'
    ];

    protected $dates = [
        'start_date',
        'finish_date'
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($member) { 
            $member->qrcode = config('app.url') . "/api/members/{$member->id}";
            $member->code = substr(rand(), 1, 6);
            $member->save();
        });
    }

    public function activity()
    {
        return $this->hasOne(Activity::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_plan')
            ->orderBy('name', 'asc');
    }
    
}
