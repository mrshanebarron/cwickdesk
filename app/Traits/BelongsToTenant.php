<?php

namespace App\Traits;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTenant
{
    /**
     * Boot the trait
     */
    protected static function bootBelongsToTenant(): void
    {
        // Automatically scope all queries to current tenant
        static::addGlobalScope('tenant', function (Builder $builder) {
            if ($tenant = static::getCurrentTenant()) {
                $builder->where(static::getTenantColumn(), $tenant->id);
            }
        });

        // Automatically set tenant_id when creating new records
        static::creating(function ($model) {
            if (!$model->getAttribute(static::getTenantColumn())) {
                if ($tenant = static::getCurrentTenant()) {
                    $model->setAttribute(static::getTenantColumn(), $tenant->id);
                }
            }
        });
    }

    /**
     * Get the current tenant
     */
    protected static function getCurrentTenant(): ?Tenant
    {
        // Check if we're in a tenant context before trying to get current tenant
        if (!app()->bound('currentTenant')) {
            return null;
        }

        return Tenant::current();
    }

    /**
     * Get the tenant column name
     */
    protected static function getTenantColumn(): string
    {
        return 'tenant_id';
    }

    /**
     * Relationship to tenant
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Query without tenant scope (admin use only)
     */
    public static function withoutTenantScope(): Builder
    {
        return static::withoutGlobalScope('tenant');
    }
}
