<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = [
        'eyebrow',
        'title',
        'description',
        'background_image',
        'mobile_image',
        'primary_button_text',
        'primary_button_url',
        'secondary_button_text',
        'secondary_button_url',
        'text_position',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
