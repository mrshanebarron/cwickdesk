<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Str;

trait LogsActivity
{
    /**
     * Boot the trait
     */
    protected static function bootLogsActivity(): void
    {
        static::created(function ($model) {
            static::logActivity($model, 'created');
        });

        static::updated(function ($model) {
            static::logActivity($model, 'updated');
        });

        static::deleted(function ($model) {
            static::logActivity($model, 'deleted');
        });
    }

    /**
     * Log the activity
     */
    protected static function logActivity($model, string $event): void
    {
        $modelName = class_basename($model);
        $modelLabel = $model->getActivityLabel();

        $description = match($event) {
            'created' => "{$modelName} '{$modelLabel}' was created",
            'updated' => "{$modelName} '{$modelLabel}' was updated",
            'deleted' => "{$modelName} '{$modelLabel}' was deleted",
            default => "{$modelName} '{$modelLabel}' - {$event}",
        };

        $properties = [];

        if ($event === 'updated' && method_exists($model, 'getActivityChanges')) {
            $properties = $model->getActivityChanges();
        }

        // Get tenant ID - check if currentTenant is bound (won't be during seeding)
        $tenantId = null;
        if (app()->bound('currentTenant') && app('currentTenant')) {
            $tenantId = app('currentTenant')->id;
        } elseif (isset($model->tenant_id)) {
            // Fallback to model's tenant_id if available
            $tenantId = $model->tenant_id;
        }

        // Get the authenticated user
        $user = auth()->user();

        ActivityLog::create([
            'tenant_id' => $tenantId,
            'description' => $description,
            'event' => $event,
            'subject_type' => get_class($model),
            'subject_id' => $model->id,
            'causer_type' => $user ? get_class($user) : null,
            'causer_id' => $user ? $user->id : null,
            'properties' => !empty($properties) ? $properties : null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Get a human-readable label for the model (override this in your model)
     */
    public function getActivityLabel(): string
    {
        if (isset($this->name)) {
            return $this->name;
        }

        if (isset($this->title)) {
            return $this->title;
        }

        if (isset($this->subject)) {
            return $this->subject;
        }

        return $this->id;
    }

    /**
     * Get changes to log (override this in your model to customize)
     */
    public function getActivityChanges(): array
    {
        $changes = [];
        $dirty = $this->getDirty();
        $original = $this->getOriginal();

        foreach ($dirty as $key => $newValue) {
            // Skip password fields and timestamps if not important
            if (in_array($key, ['password', 'remember_token'])) {
                continue;
            }

            $oldValue = $original[$key] ?? null;

            // Only log if actually changed
            if ($oldValue != $newValue) {
                $changes[$key] = [
                    'old' => $oldValue,
                    'new' => $newValue,
                ];
            }
        }

        return $changes;
    }
}
