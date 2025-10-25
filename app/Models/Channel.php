<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Channel extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'type',
        'display_order',
        'is_private',
        'required_role',
        'is_active',
    ];

    protected $casts = [
        'is_private' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Auto-generate slug from name
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($channel) {
            if (empty($channel->slug)) {
                $channel->slug = Str::slug($channel->name);
            }
        });
    }

    /**
     * Get route key name for route model binding
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Relationships
     */
    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at');
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('name');
    }

    public function scopePublic($query)
    {
        return $query->where('is_private', false);
    }
}
