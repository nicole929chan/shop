<?php

namespace App\Models;

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
        'name', 'email', 'password',
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

    public function plans()
    {
        return $this->belongsToMany(Member::class, 'user_plan')
            ->withPivot('card')
            ->withTimestamps();
    }
}