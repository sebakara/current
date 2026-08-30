<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

class FooterLink extends Model
{
    protected $fillable = [
        'footer_section_id',
        'label',
        'url',
        'route_name',
        'target',
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

    protected $appends = [
        'resolved_url',
    ];

    protected static function booted(): void
    {
        static::saved(function (): void {
            Cache::forget('website.footer-sections');
        });

        static::deleted(function (): void {
            Cache::forget('website.footer-sections');
        });
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(
            FooterSection::class,
            'footer_section_id'
        );
    }

    public function getResolvedUrlAttribute(): string
    {
        if (
            $this->route_name
            && Route::has($this->route_name)
        ) {
            return route($this->route_name);
        }

        return $this->url ?: '#';
    }
}
