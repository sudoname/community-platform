<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'channel_id',
        'user_id',
        'content',
        'attachments',
        'reply_to_message_id',
        'is_edited',
        'is_pinned',
        'edited_at',
    ];

    protected $casts = [
        'attachments' => 'array',
        'is_edited' => 'boolean',
        'is_pinned' => 'boolean',
        'edited_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replyTo()
    {
        return $this->belongsTo(Message::class, 'reply_to_message_id');
    }

    public function replies()
    {
        return $this->hasMany(Message::class, 'reply_to_message_id');
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

    public function scopeRecent($query, $limit = 50)
    {
        return $query->orderByDesc('created_at')->limit($limit);
    }
}
