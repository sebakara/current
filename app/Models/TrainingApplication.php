<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingApplication extends Model
{
    protected $fillable = [
        'course_id',
        'application_number',
        'full_name',
        'email',
        'phone',
        'gender',
        'date_of_birth',
        'nationality',
        'education_level',
        'current_occupation',
        'address',
        'motivation',
        'experience',
        'preferred_schedule',
        'document',
        'status',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'reviewed_at' => 'datetime',
        ];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'reviewed_by'
        );
    }
}
