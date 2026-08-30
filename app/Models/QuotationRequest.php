<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuotationRequest extends Model
{
    protected $fillable = [
        'reference_number',
        'name',
        'company',
        'email',
        'phone',
        'request_type',
        'service_id',
        'product_id',
        'project_description',
        'estimated_budget',
        'currency',
        'required_by',
        'attachment',
        'status',
        'assigned_to',
        'internal_notes',
        'service_type',
        'project_title',
        'budget',
        'timeline',
        'location',
        'preferred_contact_method',
        'ip_address',
        'user_agent',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'estimated_budget' => 'decimal:2',
            'required_by' => 'date',
        ];
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'assigned_to'
        );
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
