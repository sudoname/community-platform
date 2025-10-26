<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'usage_count',
    ];

    /**
     * Auto-generate slug from name
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
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
     * Get all messages tagged with this tag
     */
    public function messages()
    {
        return $this->morphedByMany(Message::class, 'taggable');
    }

    /**
     * Get all forum topics tagged with this tag
     */
    public function forumTopics()
    {
        return $this->morphedByMany(ForumTopic::class, 'taggable');
    }

    /**
     * Get all forum posts tagged with this tag
     */
    public function forumPosts()
    {
        return $this->morphedByMany(ForumPost::class, 'taggable');
    }

    /**
     * Increment usage count
     */
    public function incrementUsage()
    {
        $this->increment('usage_count');
    }

    /**
     * Decrement usage count
     */
    public function decrementUsage()
    {
        $this->decrement('usage_count');
    }

    /**
     * Scopes
     */
    public function scopePopular($query, $limit = 10)
    {
        return $query->orderByDesc('usage_count')->limit($limit);
    }

    /**
     * Find or create a tag by name
     */
    public static function findOrCreateByName(string $name): self
    {
        $slug = Str::slug($name);

        return static::firstOrCreate(
            ['slug' => $slug],
            ['name' => $name]
        );
    }

    /**
     * Extract hashtags from text
     * Returns array of tag names without the # symbol
     */
    public static function extractHashtags(string $text): array
    {
        preg_match_all('/#([a-zA-Z0-9_]+)/', $text, $matches);

        return array_unique($matches[1] ?? []);
    }
}
