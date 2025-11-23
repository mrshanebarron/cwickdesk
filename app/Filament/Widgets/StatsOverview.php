<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use App\Models\Ticket;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // Get ticket counts
        $openTickets = Ticket::whereHas('status', fn($q) => $q->where('is_resolved', false))->count();
        $myTickets = Ticket::where('assigned_to', Auth::id())
            ->whereHas('status', fn($q) => $q->where('is_resolved', false))
            ->count();
        $resolvedToday = Ticket::whereHas('status', fn($q) => $q->where('is_resolved', true))
            ->whereDate('updated_at', today())
            ->count();

        // Get total tickets for percentage calculation
        $totalTickets = Ticket::count();
        $resolvedTickets = Ticket::whereHas('status', fn($q) => $q->where('is_resolved', true))->count();
        $resolutionRate = $totalTickets > 0 ? round(($resolvedTickets / $totalTickets) * 100, 1) : 0;

        // Asset counts
        $totalAssets = Asset::count();
        $activeAssets = Asset::where('status', 'active')->count();
        $assetsInMaintenance = Asset::where('status', 'maintenance')->count();

        // Warranty alerts
        $warrantyExpiringSoon = Asset::whereNotNull('warranty_expires')
            ->whereDate('warranty_expires', '<=', now()->addDays(30))
            ->whereDate('warranty_expires', '>=', now())
            ->count();

        return [
            Stat::make('Open Tickets', $openTickets)
                ->description('Tickets awaiting resolution')
                ->descriptionIcon('heroicon-o-ticket')
                ->color('warning')
                ->chart($this->getTicketTrend()),

            Stat::make('My Assigned Tickets', $myTickets)
                ->description('Assigned to me')
                ->descriptionIcon('heroicon-o-user')
                ->color('info'),

            Stat::make('Resolved Today', $resolvedToday)
                ->description("{$resolutionRate}% overall resolution rate")
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Total Assets', $totalAssets)
                ->description("{$activeAssets} active, {$assetsInMaintenance} in maintenance")
                ->descriptionIcon('heroicon-o-rectangle-stack')
                ->color($assetsInMaintenance > 0 ? 'warning' : 'primary'),

            Stat::make('Warranty Alerts', $warrantyExpiringSoon)
                ->description('Expiring within 30 days')
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color($warrantyExpiringSoon > 0 ? 'danger' : 'success'),

            Stat::make('Total Users', User::count())
                ->description('Active users in system')
                ->descriptionIcon('heroicon-o-users')
                ->color('gray'),
        ];
    }

    /**
     * Get ticket trend for the last 7 days
     */
    protected function getTicketTrend(): array
    {
        $trend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $trend[] = Ticket::whereDate('created_at', $date)->count();
        }
        return $trend;
    }

    protected static ?int $sort = 1;
}
