<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // account's type
    const DEFAULT = 1;
    const MODERATOR = 2;
    const ADMIN = 3;

    const PAGINATION_COUNT = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'type',
        'banned_at',
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

    public function isBanned(): bool
    {
        return ! is_null($this->banned_at);
    }

    public function getAvatar(): string
    {
        return "https://gravatar.com/avatar/"
                . md5($this->email)
                ."?s=200"
                ."&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-13.png";
    }

    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class);
    }

    // account type checks
    public function isAdmin(): bool
    {
        return $this->type === self::ADMIN;
    }

    public function isModerator(): bool
    {
        return $this->type === self::MODERATOR;
    }

}
