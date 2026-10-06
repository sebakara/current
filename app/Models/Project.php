<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_category_id',
        'title',
        'slug',
        'client_name',
        'location',
        'completed_at',
        'short_description',
        'description',
        'challenge',
        'solution',
        'technologies',
        'featured_image',
        'gallery',
        'video_url',
        'is_featured',
        'is_published',
        'sort_order',
        'views',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'technologies' => 'array',
            'gallery' => 'array',
            'completed_at' => 'date',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
            'views' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            ProjectCategory::class,
            'project_category_id'
        );
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
