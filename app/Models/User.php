<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'birth_year', 'birth_month'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function($user) {
            $user->password = bcrypt($user->password);
            $user->code = substr(rand(), 1, 6);
        });
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * getJWTIdentifier descrition
     *
     * @return [type] [description]
     */
    public function getJWTIdentifier()
    {
        return $this->id;
    }
    /**
     * getJWTCustomClaims descrition
     *
     * @return [type] [description]
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token, $this->email));
    }

    public function plans()
    {
        return $this->belongsToMany(Member::class, 'user_plan')
            ->withPivot(['card', 'redeem'])
            ->withTimestamps();
    }

    /**
     * 點數增減紀錄
     *
     * @return void
     */
    public function points()
    {
        return $this->hasMany(Point::class);
    }

    /**
     * 各店家的剩餘點數紀錄
     *
     * @return void
     */
    public function point()
    {
        return $this->belongsToMany(User::class, 'user_member_point_view')
            ->withPivot(['points', 'member_id']);
    }

    /**
     * 單一店家的剩餘點數
     *
     * @param integer $memberId
     * @return void
     */
    public function pointByMember($memberId)
    {
        return $this->belongsToMany(User::class, 'user_member_point_view')
            ->wherePivot('member_id', $memberId)
            ->withPivot(['points', 'member_id'])
            ->first();
    }
}
