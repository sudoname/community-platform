<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'paid_expiration',
        'subscription_tier',
        'avatar',
        'bio',
        'is_active',
        'provider',
        'provider_id',
        'provider_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'paid_expiration' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Role helper methods
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPaidMember(): bool
    {
        return $this->role === 'paid_member';
    }

    public function isFreeMember(): bool
    {
        return $this->role === 'free_member';
    }

    /**
     * Relationships
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function forumTopics()
    {
        return $this->hasMany(ForumTopic::class);
    }

    public function forumPosts()
    {
        return $this->hasMany(ForumPost::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }
}
