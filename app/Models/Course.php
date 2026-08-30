<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'course_category_id',
        'title',
        'slug',
        'code',
        'short_description',
        'overview',
        'description',
        'requirements',
        'learning_outcomes',
        'outcomes',
        'duration',
        'schedule',
        'delivery_mode',
        'location',
        'fee',
        'currency',
        'featured_image',
        'gallery',
        'modules',
        'curriculum',
        'application_deadline',
        'starts_at',
        'ends_at',
        'start_date',
        'available_places',
        'max_students',
        'applications_open',
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
            'gallery' => 'array',
            'modules' => 'array',
            'curriculum' => 'array',
            'fee' => 'decimal:2',
            'application_deadline' => 'date',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'start_date' => 'date',
            'available_places' => 'integer',
            'max_students' => 'integer',
            'applications_open' => 'boolean',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
            'views' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            CourseCategory::class,
            'course_category_id'
        );
    }

    public function applications(): HasMany
    {
        return $this->hasMany(
            TrainingApplication::class,
            'course_id'
        );
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function applicationsAreOpen(): bool
    {
        if (! $this->is_published || ! $this->applications_open) {
            return false;
        }

        if (
            $this->application_deadline
            && now()->startOfDay()->greaterThan(
                $this->application_deadline
            )
        ) {
            return false;
        }

        if (
            $this->available_places !== null
            && $this->available_places <= 0
        ) {
            return false;
        }

        return true;
    }
}
