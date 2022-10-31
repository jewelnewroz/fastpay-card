<?php

namespace App\Models;

use App\Channels\SmsChannel;
use App\Notifications\OtpNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'status',
        'mobile',
        'password'
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
    ];

    public $observables = [
        'updated'
    ];

    public function getNiceStatusAttribute()
    {
        return config('common.user.statuses')[$this->status];
    }

    public function sendOtp($otp)
    {
        $otp = Otp::create(['user_id' => $this->id, 'otp' => $otp]);
        $this->notify(new OtpNotification($otp, [SmsChannel::class]));
    }
}
