<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_category_id',
        'name',
        'slug',
        'sku',
        'short_description',
        'description',
        'features',
        'specifications',
        'featured_image',
        'gallery',
        'video_url',
        'datasheet',
        'price',
        'sale_price',
        'currency',
        'show_price',
        'is_featured',
        'is_published',
        'sort_order',
        'views',
        'minimum_order_quantity',
        'stock_quantity',
        'manage_stock',
        'allow_backorders',
        'cart_enabled',
        'whatsapp_order_enabled',
        'options',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'specifications' => 'array',
            'gallery' => 'array',
            'options' => 'array',
            'price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'show_price' => 'boolean',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'manage_stock' => 'boolean',
            'allow_backorders' => 'boolean',
            'cart_enabled' => 'boolean',
            'whatsapp_order_enabled' => 'boolean',
            'sort_order' => 'integer',
            'views' => 'integer',
            'minimum_order_quantity' => 'integer',
            'stock_quantity' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            ProductCategory::class,
            'product_category_id'
        );
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getCurrentPriceAttribute(): ?float
    {
        if ($this->sale_price !== null) {
            return (float) $this->sale_price;
        }

        return $this->price !== null
            ? (float) $this->price
            : null;
    }

    public function isPurchasable(): bool
    {
        if (! $this->is_published || ! $this->cart_enabled) {
            return false;
        }

        if (! $this->manage_stock) {
            return true;
        }

        return $this->allow_backorders
            || (int) $this->stock_quantity > 0;
    }
}
