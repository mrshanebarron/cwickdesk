<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SlackIntegration extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'team_id',
        'team_name',
        'channel_id',
        'channel_name',
        'access_token',
        'bot_token',
        'webhook_url',
        'scopes',
        'active',
        'notification_events',
    ];

    protected $casts = [
        'scopes' => 'array',
        'notification_events' => 'array',
        'active' => 'boolean',
    ];

    protected $hidden = [
        'access_token',
        'bot_token',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Encrypt/decrypt access token
     */
    protected function accessToken(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? decrypt($value) : null,
            set: fn($value) => $value ? encrypt($value) : null,
        );
    }

    /**
     * Encrypt/decrypt bot token
     */
    protected function botToken(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? decrypt($value) : null,
            set: fn($value) => $value ? encrypt($value) : null,
        );
    }

    /**
     * Check if this integration should notify for a specific event
     */
    public function shouldNotifyFor(string $event): bool
    {
        if (!$this->active) {
            return false;
        }

        $events = $this->notification_events ?? [];
        return empty($events) || in_array($event, $events);
    }
}
