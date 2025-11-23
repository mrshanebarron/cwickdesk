<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use App\Models\TicketStatus;
use Filament\Widgets\ChartWidget;

class TicketsByStatusChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $statuses = TicketStatus::all();

        $labels = [];
        $data = [];
        $colors = [];

        foreach ($statuses as $status) {
            $count = Ticket::where('status_id', $status->id)->count();

            if ($count > 0) {
                $labels[] = $status->name;
                $data[] = $count;

                // Assign colors based on whether it's resolved or not
                $colors[] = $status->is_resolved
                    ? 'rgb(34, 197, 94)' // Green for resolved
                    : ($status->name === 'New'
                        ? 'rgb(251, 191, 36)' // Yellow for new
                        : 'rgb(59, 130, 246)'); // Blue for in progress
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Tickets',
                    'data' => $data,
                    'backgroundColor' => $colors,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    public function getHeading(): ?string
    {
        return 'Tickets By Status';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}
