<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    use BelongsToTenant;

    protected $table = 'activity_log';

    protected $fillable = [
        'tenant_id',
        'log_name',
        'description',
        'event',
        'subject_type',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties',
        'batch_uuid',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    /**
     * The tenant this log belongs to
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * The user who performed the action (causer)
     */
    public function causer(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * The model that was affected (subject)
     */
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Helper to create an activity log entry
     */
    public static function log(string $event, Model $subject, ?array $properties = null): self
    {
        // Get tenant ID safely - check if currentTenant is bound
        $tenantId = null;
        if (app()->bound('currentTenant') && app('currentTenant')) {
            $tenantId = app('currentTenant')->id;
        }

        return static::create([
            'tenant_id' => $tenantId,
            'user_id' => auth()->id(),
            'event' => $event,
            'subject_type' => get_class($subject),
            'subject_id' => $subject->id,
            'properties' => $properties,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
