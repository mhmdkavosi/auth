<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    static function updateToken($id){
        return User::where('id',$id)
            ->update([
                'token'=>\Function_helper::makeToken()
            ]);
    }
    static function checkUser($token){
        return User::select('token')
            ->where('token',$token)
            ->exists();
    }
    static function user_id($token){
        return User::select('token','id')
            ->where('token',$token)
            ->pluck('id');
    }
    public function Roles()
    {
        return $this->hasMany(UserRole::class,'user_id','id');
    }
}
