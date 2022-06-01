<?php

namespace Dealskoo\User\Models;

use Dealskoo\Admin\Traits\HasSlug;
use Dealskoo\Country\Traits\HasCountry;
use Dealskoo\User\Notifications\ResetUserPassword;
use Dealskoo\User\Notifications\VerifyUserEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authentication;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;
use Laravolt\Avatar\Facade as Avatar;

class User extends Authentication implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes, HasCountry, HasSlug, Searchable;

    protected $fillable = [
        'slug',
        'avatar',
        'cover',
        'name',
        'bio',
        'email',
        'password',
        'country_id',
        'company_name',
        'website',
        'status',
        'source'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'boolean',
    ];

    public function getAvatarUrlAttribute()
    {
        return empty($this->avatar) ?
            Avatar::create($this->email)->toGravatar(['d' => 'identicon', 'r' => 'pg', 's' => 100]) :
            Storage::url($this->avatar);
    }

    public function getCoverUrlAttribute()
    {
        return empty($this->cover) ? null : Storage::url($this->cover);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetUserPassword($token));
    }

    public function routeNotificationForMail($notification)
    {
        return [$this->email => $this->name];
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyUserEmail());
    }

    public function shouldBeSearchable()
    {
        return $this->status;
    }

    public function toSearchableArray()
    {
        return $this->only([
            'slug',
            'name',
            'bio',
            'email',
            'country_id',
            'company_name',
            'website',
            'source'
        ]);
    }
}
