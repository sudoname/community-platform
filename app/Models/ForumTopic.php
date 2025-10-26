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
        'allowed_roles',
        'views_count',
        'replies_count',
        'last_activity_at',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
        'allowed_roles' => 'array',
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

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Attach tags from content
     */
    public function syncTagsFromContent()
    {
        $hashtags = Tag::extractHashtags($this->content);
        $tagIds = [];

        foreach ($hashtags as $tagName) {
            $tag = Tag::findOrCreateByName($tagName);
            $tagIds[] = $tag->id;
        }

        // Sync tags (attach new, detach old)
        $this->tags()->sync($tagIds);

        // Update usage counts
        foreach ($this->tags as $tag) {
            $tag->usage_count = $tag->messages()->count() + $tag->forumTopics()->count() + $tag->forumPosts()->count();
            $tag->save();
        }
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
