<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use SoftDeletes, LogsActivity, BelongsToTenant;

    protected $fillable = [
        'asset_tag',
        'name',
        'description',
        'category_id',
        'manufacturer',
        'model',
        'serial_number',
        'mac_address',
        'ip_address',
        'assigned_to_id',
        'location',
        'department',
        'purchase_date',
        'purchase_cost',
        'warranty_expires',
        'status',
        'notes',
        'custom_fields',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'warranty_expires' => 'date',
        'purchase_cost' => 'decimal:2',
        'custom_fields' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(AssetCategory::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function isWarrantyExpired(): bool
    {
        return $this->warranty_expires && $this->warranty_expires->isPast();
    }

    public function isWarrantyExpiringSoon(int $days = 30): bool
    {
        return $this->warranty_expires &&
               $this->warranty_expires->isFuture() &&
               $this->warranty_expires->diffInDays(now()) <= $days;
    }
}
