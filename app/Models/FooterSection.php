<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class FooterSection extends Model
{
    protected $fillable = [
        'title',
        'section_key',
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
            Cache::forget('website.footer-sections');
        });

        static::deleted(function (): void {
            Cache::forget('website.footer-sections');
        });
    }

    public function links(): HasMany
    {
        return $this->hasMany(FooterLink::class)
            ->orderBy('sort_order')
            ->orderBy('label');
    }

    public function activeLinks(): HasMany
    {
        return $this->hasMany(FooterLink::class)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('label');
    }
}
