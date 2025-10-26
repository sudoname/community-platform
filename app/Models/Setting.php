<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type'];

    /**
     * Get a setting value by key
     */
    public static function get($key, $default = null)
    {
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set a setting value
     */
    public static function set($key, $value, $type = 'text')
    {
        Cache::forget("setting_{$key}");

        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type]
        );
    }

    /**
     * Check if setting is boolean true
     */
    public static function isEnabled($key)
    {
        return static::get($key) === '1' || static::get($key) === true;
    }
}
