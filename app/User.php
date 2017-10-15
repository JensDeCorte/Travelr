<?php

namespace App;

use Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'first_name', 'last_name', 'fb_id', 'fb_token', 'time_zone', 'unit_is_km', 'temperature_is_celsius', 'profile_image', 'profile_image_cover', 'profile_image_thumb'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Automatically creates hash for the user password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }


    public function trip()
    {
        return $this->hasMany('App\Trip');
    }

    public function followers()
    {
        return $this->hasMany('App\Follower');
    }

}
