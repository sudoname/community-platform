<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'plan',
        'status',
        'stripe_subscription_id',
        'amount',
        'billing_interval',
        'trial_ends_at',
        'starts_at',
        'ends_at',
        'cancelled_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'trial_ends_at' => 'datetime',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helpers
     */
    public function isActive()
    {
        return $this->status === 'active' && (!$this->ends_at || $this->ends_at->isFuture());
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    public function isExpired()
    {
        return $this->status === 'expired' || ($this->ends_at && $this->ends_at->isPast());
    }

    public function onTrial()
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }
}
