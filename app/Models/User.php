<?php

namespace App\Models;

use App\Constants\Role;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\VerifyEmailQueued;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable;
    use \Spatie\Permission\Traits\HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    /**
     * @return HasMany
     */
    public function providers()
    {
        return $this->hasMany(Provider::class, 'user_id', 'id');
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    protected static function booted(): void
    {
        static::created(function (User $user) {
            $user->profile()->create([]);
            $user->assignRole(Role::USER);
        });
    }
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailQueued);
    }
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
    public function favourites(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'favourites');
    }
}
