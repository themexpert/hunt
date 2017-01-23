<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_active', 'token'
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
     * Determine given email is developer or not.
     *
     * @param string $email
     * @return bool
     */
    public static function developer($email)
    {
        return in_array($email, config('developers'));
    }

    /**
     * Get all developers.
     *
     * @return array
     */
    public static function developers()
    {
        return config('developers');
    }
}
