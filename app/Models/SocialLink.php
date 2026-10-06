<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SocialLink extends Model
{
    protected $fillable = [
        'platform',
        'url',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saved(function (): void {
            Cache::forget('website.social-links');
        });

        static::deleted(function (): void {
            Cache::forget('website.social-links');
        });
    }
}
