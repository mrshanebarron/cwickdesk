<?php

namespace App\Filament\Resources\Tickets\Tables;

use App\Models\TicketPriority;
use App\Models\TicketStatus;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ticket_number')
                    ->label('Ticket #')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),

                TextColumn::make('subject')
                    ->label('Subject')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }
                        return $state;
                    }),

                BadgeColumn::make('status.name')
                    ->label('Status')
                    ->colors([
                        'primary',
                    ])
                    ->formatStateUsing(fn ($record) => $record->status->name ?? 'Unknown')
                    ->color(fn ($record) => $record->status->color ?? 'gray'),

                BadgeColumn::make('priority.name')
                    ->label('Priority')
                    ->colors([
                        'primary',
                    ])
                    ->formatStateUsing(fn ($record) => $record->priority->name ?? 'Unknown')
                    ->color(fn ($record) => $record->priority->color ?? 'gray'),

                TextColumn::make('requester.name')
                    ->label('Requester')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('assignedTo.name')
                    ->label('Assigned To')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Unassigned')
                    ->default('—'),

                TextColumn::make('asset.name')
                    ->label('Asset')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('source')
                    ->label('Source')
                    ->badge()
                    ->colors([
                        'primary' => 'web',
                        'success' => 'email',
                        'warning' => 'phone',
                        'info' => 'walk-in',
                    ])
                    ->toggleable(),

                IconColumn::make('is_internal')
                    ->label('Internal')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('due_date')
                    ->label('Due Date')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->color(fn ($record) => $record->isOverdue() ? 'danger' : null)
                    ->weight(fn ($record) => $record->isOverdue() ? 'bold' : null)
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Age')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->badge()
                    ->color(function ($record) {
                        // Only show age warnings for open tickets
                        if ($record->status && $record->status->is_resolved) {
                            return 'success';
                        }

                        $hoursOld = $record->created_at->diffInHours(now());
                        $priority = $record->priority->name ?? 'Medium';

                        // Critical tickets
                        if ($priority === 'Critical') {
                            if ($hoursOld > 4) return 'danger';  // Over 4 hours
                            if ($hoursOld > 2) return 'warning'; // Over 2 hours
                            return 'info';
                        }

                        // High priority
                        if ($priority === 'High') {
                            if ($hoursOld > 24) return 'danger';  // Over 1 day
                            if ($hoursOld > 8) return 'warning';  // Over 8 hours
                            return 'info';
                        }

                        // Medium priority
                        if ($hoursOld > 72) return 'danger';   // Over 3 days
                        if ($hoursOld > 48) return 'warning';  // Over 2 days
                        return 'gray';
                    })
                    ->formatStateUsing(function ($record) {
                        $hoursOld = $record->created_at->diffInHours(now());

                        if ($hoursOld < 1) {
                            return 'Just now';
                        } elseif ($hoursOld < 24) {
                            return $hoursOld . 'h old';
                        } else {
                            $days = floor($hoursOld / 24);
                            return $days . 'd old';
                        }
                    })
                    ->description(fn ($record) => $record->created_at->format('M j, Y g:i A'))
                    ->toggleable(),

                TextColumn::make('time_spent')
                    ->label('Time Spent')
                    ->formatStateUsing(fn ($state) => $state > 0 ? "{$state} min" : '—')
                    ->alignEnd()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('resolved_at')
                    ->label('Resolved')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->relationship('status', 'name')
                    ->preload()
                    ->multiple(),

                SelectFilter::make('priority')
                    ->relationship('priority', 'name')
                    ->preload()
                    ->multiple(),

                SelectFilter::make('assigned_to')
                    ->relationship('assignedTo', 'name')
                    ->label('Assigned To')
                    ->preload()
                    ->multiple(),

                SelectFilter::make('requester')
                    ->relationship('requester', 'name')
                    ->preload()
                    ->searchable(),

                Filter::make('unassigned')
                    ->query(fn (Builder $query): Builder => $query->whereNull('assigned_to_id'))
                    ->toggle(),

                Filter::make('my_tickets')
                    ->query(fn (Builder $query): Builder => $query->where('assigned_to_id', auth()->id()))
                    ->toggle()
                    ->label('My Tickets'),

                Filter::make('overdue')
                    ->query(fn (Builder $query): Builder => $query
                        ->whereNotNull('due_date')
                        ->where('due_date', '<', now())
                        ->whereDoesntHave('status', fn ($q) => $q->where('is_closed', true)))
                    ->toggle(),

                Filter::make('open')
                    ->query(fn (Builder $query): Builder => $query
                        ->whereHas('status', fn ($q) => $q->where('is_closed', false)))
                    ->default()
                    ->toggle(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('assign')
                        ->label('Assign to User')
                        ->icon('heroicon-o-user')
                        ->form([
                            Select::make('assigned_to_id')
                                ->label('Assign To')
                                ->options(User::role(['agent', 'admin', 'super_admin'])->pluck('name', 'id'))
                                ->searchable()
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data) {
                            $records->each->update(['assigned_to' => $data['assigned_to_id']]);

                            Notification::make()
                                ->title('Tickets assigned successfully')
                                ->success()
                                ->body($records->count() . ' ticket(s) assigned to ' . User::find($data['assigned_to_id'])->name)
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('change_status')
                        ->label('Change Status')
                        ->icon('heroicon-o-arrow-path')
                        ->form([
                            Select::make('status_id')
                                ->label('Status')
                                ->options(TicketStatus::pluck('name', 'id'))
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data) {
                            $records->each->update(['status_id' => $data['status_id']]);

                            Notification::make()
                                ->title('Status changed successfully')
                                ->success()
                                ->body($records->count() . ' ticket(s) updated')
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('change_priority')
                        ->label('Change Priority')
                        ->icon('heroicon-o-exclamation-triangle')
                        ->form([
                            Select::make('priority_id')
                                ->label('Priority')
                                ->options(TicketPriority::pluck('name', 'id'))
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data) {
                            $records->each->update(['priority_id' => $data['priority_id']]);

                            Notification::make()
                                ->title('Priority changed successfully')
                                ->success()
                                ->body($records->count() . ' ticket(s) updated')
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),

                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s') // Auto-refresh every 30 seconds
            ->emptyStateHeading('No tickets here yet!')
            ->emptyStateDescription('Let\'s create your first support ticket to get started.')
            ->emptyStateIcon('heroicon-o-ticket')
            ->emptyStateActions([
                \Filament\Actions\CreateAction::make()
                    ->label('Create First Ticket')
                    ->icon('heroicon-o-plus-circle'),
            ]);
    }
}
