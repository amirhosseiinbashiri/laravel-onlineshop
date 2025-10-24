<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username',
        'password',
        'phone',
        'is_admin',
        'otp_code',
        'otp_expires_at',
    ];

    protected $hidden = [
        'password',
        'otp_code',
    ];

    protected function casts(): array
    {
        return [
            'is_admin' => 'boolean',
            'otp_expires_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
