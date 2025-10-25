<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ForumTopic extends Model
{
    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'content',
        'is_pinned',
        'is_locked',
        'views_count',
        'replies_count',
        'last_activity_at',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
        'last_activity_at' => 'datetime',
    ];

    /**
     * Auto-generate slug from title
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($topic) {
            if (empty($topic->slug)) {
                $topic->slug = Str::slug($topic->title);
            }
            $topic->last_activity_at = now();
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
    public function category()
    {
        return $this->belongsTo(ForumCategory::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->hasMany(ForumPost::class, 'topic_id')->orderBy('created_at');
    }

    /**
     * Scopes
     */
    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeActive($query)
    {
        return $query->orderByDesc('is_pinned')->orderByDesc('last_activity_at');
    }
}
