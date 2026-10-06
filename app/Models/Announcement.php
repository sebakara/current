<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'message',
        'button_text',
        'button_url',
        'type',
        'starts_at',
        'ends_at',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saved(function (): void {
            Cache::forget('website.active-announcement');
        });

        static::deleted(function (): void {
            Cache::forget('website.active-announcement');
        });
    }

    public function scopeCurrentlyActive(
        Builder $query
    ): Builder {
        return $query
            ->where('is_active', true)
            ->where(function (Builder $builder) {
                $builder
                    ->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->where(function (Builder $builder) {
                $builder
                    ->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', now());
            });
    }
}
