<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property PersonalInfo personalInfo
 * @method static find(string $id)
 */
class User extends Authenticatable implements \Illuminate\Contracts\Auth\CanResetPassword
{
    use HasFactory, Notifiable, UuidTrait, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function personalInfo(): HasOne
    {
        return $this->hasOne(PersonalInfo::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $frontendUrl = config("app.frontend_url");
        $url =  "{$frontendUrl}/reset-password/{$token}";
        $this->notify(new CustomResetPasswordNotification($url));
    }
}
