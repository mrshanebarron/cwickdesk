<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use App\Models\TicketStatus;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TicketStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $openStatus = TicketStatus::where('is_closed', false)->pluck('id');
        $closedStatus = TicketStatus::where('is_closed', true)->pluck('id');

        $openTickets = Ticket::whereIn('status_id', $openStatus)->count();
        $closedToday = Ticket::whereIn('status_id', $closedStatus)
            ->whereDate('closed_at', today())
            ->count();
        $myTickets = Ticket::where('assigned_to_id', auth()->id())
            ->whereIn('status_id', $openStatus)
            ->count();
        $overdueTickets = Ticket::whereNotNull('due_date')
            ->where('due_date', '<', now())
            ->whereIn('status_id', $openStatus)
            ->count();

        return [
            Stat::make('Open Tickets', $openTickets)
                ->description('Currently open')
                ->descriptionIcon('heroicon-m-ticket')
                ->color('primary')
                ->chart([7, 12, 10, $openTickets]),

            Stat::make('My Tickets', $myTickets)
                ->description('Assigned to me')
                ->descriptionIcon('heroicon-m-user')
                ->color('success')
                ->url(route('filament.admin.resources.tickets.index', [
                    'tableFilters' => ['my_tickets' => ['isActive' => true]]
                ])),

            Stat::make('Overdue', $overdueTickets)
                ->description('Past due date')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($overdueTickets > 0 ? 'danger' : 'success'),

            Stat::make('Closed Today', $closedToday)
                ->description('Resolved today')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('info'),
        ];
    }
}
