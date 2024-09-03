<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Client extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable;
    protected $guard = 'client';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'user_name',
        'email',
        'password',
        'image',
        'verify_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'verify_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    /**
     * Get the password reset token attribute.
     *
     * @return string|null
     */
    public function getRememberToken()
    {
        return $this->verify_token;
    }

    /**
     * Set the password reset token.
     *
     * @param  string|null  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->verify_token = $value;
    }

    /**
     * Get the name of the column for the remember me token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'verify_token';
    }
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
