<?php

namespace App\Filament\Resources\Tickets\Schemas;

use App\Models\Ticket;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TicketInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Ticket Information')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('ticket_number')
                                    ->label('Ticket #')
                                    ->weight('bold')
                                    ->copyable(),

                                TextEntry::make('source')
                                    ->label('Source')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'web' => 'primary',
                                        'email' => 'success',
                                        'phone' => 'warning',
                                        'walk-in' => 'info',
                                        default => 'gray',
                                    }),

                                IconEntry::make('is_internal')
                                    ->label('Internal Ticket')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-lock-closed')
                                    ->falseIcon('heroicon-o-globe-alt')
                                    ->trueColor('warning')
                                    ->falseColor('success'),
                            ]),

                        TextEntry::make('subject')
                            ->label('Subject')
                            ->size('lg')
                            ->weight('bold')
                            ->columnSpanFull(),

                        TextEntry::make('description')
                            ->label('Description')
                            ->html()
                            ->columnSpanFull(),
                    ]),

                Section::make('Assignment & Status')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('requester.name')
                                    ->label('Requester'),

                                TextEntry::make('assignedTo.name')
                                    ->label('Assigned To')
                                    ->placeholder('Unassigned')
                                    ->default('—'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextEntry::make('priority.name')
                                    ->label('Priority')
                                    ->badge()
                                    ->color(fn ($record) => $record->priority->color ?? 'gray'),

                                TextEntry::make('status.name')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn ($record) => $record->status->color ?? 'gray'),
                            ]),
                    ]),

                Section::make('Dates & Timeline')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Created')
                                    ->dateTime('M j, Y g:i A'),

                                TextEntry::make('due_date')
                                    ->label('Due Date')
                                    ->dateTime('M j, Y g:i A')
                                    ->placeholder('No due date')
                                    ->color(fn ($record) => $record->isOverdue() ? 'danger' : null)
                                    ->weight(fn ($record) => $record->isOverdue() ? 'bold' : null),
                            ]),

                        Grid::make(3)
                            ->schema([
                                TextEntry::make('first_response_at')
                                    ->label('First Response')
                                    ->dateTime('M j, Y g:i A')
                                    ->placeholder('—'),

                                TextEntry::make('resolved_at')
                                    ->label('Resolved')
                                    ->dateTime('M j, Y g:i A')
                                    ->placeholder('—'),

                                TextEntry::make('closed_at')
                                    ->label('Closed')
                                    ->dateTime('M j, Y g:i A')
                                    ->placeholder('—'),
                            ]),
                    ]),

                Section::make('Additional Information')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('asset.name')
                                    ->label('Related Asset')
                                    ->placeholder('No asset linked')
                                    ->default('—'),

                                TextEntry::make('time_spent')
                                    ->label('Time Spent')
                                    ->formatStateUsing(fn ($state) => $state > 0 ? "{$state} minutes" : '—'),

                                TextEntry::make('email_message_id')
                                    ->label('Email Message ID')
                                    ->placeholder('—')
                                    ->visible(fn ($state) => filled($state)),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
