<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $fillable = [
        'stock_symbol',
        'stock_name',
        'type',
        'option_type',
        'strike_price',
        'expiration_date',
        'action',
        'price',
        'notes',
        'show_in_marquee',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'strike_price' => 'decimal:2',
        'expiration_date' => 'date',
        'show_in_marquee' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeMarquee($query)
    {
        return $query->where('show_in_marquee', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('stock_symbol');
    }
}
