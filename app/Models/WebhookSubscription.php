<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WebhookSubscription extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'name',
        'url',
        'events',
        'secret',
        'active',
        'headers',
        'retry_attempts',
        'last_delivered_at',
        'last_failed_at',
        'last_error',
    ];

    protected $casts = [
        'events' => 'array',
        'headers' => 'array',
        'active' => 'boolean',
        'last_delivered_at' => 'datetime',
        'last_failed_at' => 'datetime',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function deliveries(): HasMany
    {
        return $this->hasMany(WebhookDelivery::class);
    }

    /**
     * Check if this webhook is subscribed to a specific event
     */
    public function isSubscribedTo(string $event): bool
    {
        return in_array($event, $this->events ?? []);
    }

    /**
     * Generate webhook signature for payload verification
     */
    public function generateSignature(array $payload): string
    {
        return hash_hmac('sha256', json_encode($payload), $this->secret);
    }
}
