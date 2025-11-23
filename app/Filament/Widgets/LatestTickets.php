<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestTickets extends TableWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Ticket::query()
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('ticket_number')
                    ->label('Ticket #')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->color('primary'),

                TextColumn::make('subject')
                    ->label('Subject')
                    ->searchable()
                    ->limit(50)
                    ->wrap(),

                TextColumn::make('requester.name')
                    ->label('Requester')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status.name')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($record) => $record->status->is_resolved ? 'success' : 'warning'),

                TextColumn::make('priority.name')
                    ->label('Priority')
                    ->badge()
                    ->color(fn ($record) => match($record->priority->name) {
                        'Critical' => 'danger',
                        'High' => 'warning',
                        'Medium' => 'info',
                        'Low' => 'gray',
                        default => 'gray',
                    }),

                TextColumn::make('assignedTo.name')
                    ->label('Assigned To')
                    ->placeholder('Unassigned')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->since(),
            ])
            ->recordAction('view')
            ->recordActions([
                Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Ticket $record): string => route('filament.admin.resources.tickets.edit', $record)),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public function getTableHeading(): ?string
    {
        return 'Latest Tickets';
    }
}
