<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $table = "USERS";

    public $timestamps = false;

    protected $primaryKey = 'USR_NAME';

    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "USR_NAME", 'USR_PASSWD', "USR_GROUPE", "USR_RIGHTS", "SAL_CODE",
        "USR_WSTLCU", "USR_DTLAST", "USR_DORT", "USR_DTMAJ", "USR_USRMAJ",
        "USR_NUMMAJ", 'email', 'password', 'social_name', 'social_id',
        'social_token', 'social_refresh_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
