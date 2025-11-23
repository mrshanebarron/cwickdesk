<?php

namespace App\Filament\Platform\Widgets;

use App\Models\Tenant;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PlatformStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalTenants = Tenant::count();
        $activeTenants = Tenant::where('status', 'active')->count();
        $trialTenants = Tenant::where('status', 'trial')->count();
        $suspendedTenants = Tenant::where('status', 'suspended')->count();

        // Calculate MRR (Monthly Recurring Revenue)
        $mrr = Tenant::where('status', 'active')
            ->where('is_internal', false)
            ->get()
            ->sum(function ($tenant) {
                return match ($tenant->plan) {
                    'starter' => 49,
                    'professional' => 149,
                    'enterprise' => 399,
                    default => 0,
                };
            });

        return [
            Stat::make('Total Tenants', $totalTenants)
                ->description('All customer accounts')
                ->descriptionIcon('heroicon-o-building-office-2')
                ->color('primary'),

            Stat::make('Active Subscriptions', $activeTenants)
                ->description('Paying customers')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Trial Accounts', $trialTenants)
                ->description('14-day trial period')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('Monthly Recurring Revenue', '$' . number_format($mrr))
                ->description('From ' . Tenant::where('status', 'active')->where('is_internal', false)->count() . ' paying customers')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success'),
        ];
    }
}
