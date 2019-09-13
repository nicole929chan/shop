<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'code', 'phone_number', 'address', 'qrcode', 'email', 'password', 'start_date', 'finish_date', 'logo', 'admin'
    ];

    protected $dateFormat = 'Y-m-d H:i:s.u';

    public static function boot()
    {
        parent::boot();

        static::created(function ($member) { 
            $member->qrcode = config('app.url') . "/api/members/{$member->id}";
            $member->code = substr(rand(), 1, 6);
            $member->save();
        });
    }

    public function setFinishDateAttribute($date)
    {
        return $this->attributes['finish_date'] = Carbon::createFromFormat('Y-m-d', $date)->endOfDay();
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
