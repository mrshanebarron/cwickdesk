<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Cashier\Billable;
use Spatie\Multitenancy\Models\Tenant as SpatieTenant;

class Tenant extends SpatieTenant
{
    use SoftDeletes, Billable;

    protected $fillable = [
        'name',
        'slug',
        'domain',
        'database',
        'contact_name',
        'contact_email',
        'contact_phone',
        'plan',
        'status',
        'is_internal',
        'trial_ends_at',
        'stripe_id',
        'logo_url',
        'primary_color',
        'secondary_color',
        'max_users',
        'max_tickets_per_month',
        'max_assets',
        'settings',
        'last_active_at',
        'onboarding_completed',
        'onboarding_steps',
    ];

    protected $casts = [
        'settings' => 'array',
        'onboarding_steps' => 'array',
        'is_internal' => 'boolean',
        'onboarding_completed' => 'boolean',
        'trial_ends_at' => 'datetime',
        'last_active_at' => 'datetime',
        'max_users' => 'integer',
        'max_tickets_per_month' => 'integer',
        'max_assets' => 'integer',
    ];

    /**
     * Check if tenant is on trial
     */
    public function isOnTrial(): bool
    {
        return $this->status === 'trial' &&
               $this->trial_ends_at &&
               $this->trial_ends_at->isFuture();
    }

    /**
     * Check if trial has expired
     */
    public function hasExpiredTrial(): bool
    {
        return $this->status === 'trial' &&
               $this->trial_ends_at &&
               $this->trial_ends_at->isPast();
    }

    /**
     * Check if tenant is active
     */
    public function isActive(): bool
    {
        return in_array($this->status, ['active', 'trial']);
    }

    /**
     * Check if tenant can access a feature based on plan
     */
    public function hasFeature(string $feature): bool
    {
        $features = [
            'free' => ['basic_ticketing', 'kb_articles', 'basic_assets'],
            'basic' => ['basic_ticketing', 'kb_articles', 'basic_assets', 'canned_responses', 'ticket_templates'],
            'pro' => ['basic_ticketing', 'kb_articles', 'basic_assets', 'canned_responses', 'ticket_templates', 'sla_management', 'warranty_alerts', 'audit_log', 'bulk_actions'],
            'enterprise' => ['all'],
        ];

        if ($this->plan === 'enterprise') {
            return true;
        }

        return in_array($feature, $features[$this->plan] ?? []);
    }

    /**
     * Get the URL for the tenant
     */
    public function getUrlAttribute(): string
    {
        if ($this->domain) {
            return 'https://' . $this->domain;
        }

        return 'https://' . $this->slug . '.' . config('app.domain');
    }

    /**
     * Update last active timestamp
     */
    public function recordActivity(): void
    {
        $this->update(['last_active_at' => now()]);
    }

    /**
     * Get all users belonging to this tenant
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check if this is an internal tenant (no billing required)
     */
    public function isInternal(): bool
    {
        return $this->is_internal === true;
    }

    /**
     * Check if this tenant requires billing
     */
    public function requiresBilling(): bool
    {
        return !$this->isInternal();
    }

    /**
     * Check if tenant should see trial/billing UI
     */
    public function shouldShowBillingUI(): bool
    {
        return $this->requiresBilling();
    }
}
