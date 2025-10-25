<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    protected $fillable = [
        'topic_id',
        'user_id',
        'reply_to_post_id',
        'content',
        'is_edited',
        'edited_at',
    ];

    protected $casts = [
        'is_edited' => 'boolean',
        'edited_at' => 'datetime',
    ];

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($post) {
            // Update topic reply count and last activity
            $topic = $post->topic;
            $topic->increment('replies_count');
            $topic->update(['last_activity_at' => now()]);
        });
    }

    /**
     * Relationships
     */
    public function topic()
    {
        return $this->belongsTo(ForumTopic::class, 'topic_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replyTo()
    {
        return $this->belongsTo(ForumPost::class, 'reply_to_post_id');
    }

    public function replies()
    {
        return $this->hasMany(ForumPost::class, 'reply_to_post_id');
    }
}
