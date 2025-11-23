<?php

namespace App\Filament\Resources\Assets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AssetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asset_tag')
                    ->label('Asset Tag')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold')
                    ->color('primary'),

                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->description)
                    ->wrap()
                    ->limit(50),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('status')
                    ->label('Status')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'in_storage' => 'gray',
                        'maintenance' => 'warning',
                        'broken' => 'danger',
                        'retired' => 'secondary',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'Active',
                        'in_storage' => 'In Storage',
                        'maintenance' => 'Maintenance',
                        'broken' => 'Broken',
                        'retired' => 'Retired',
                        default => $state,
                    }),

                TextColumn::make('assignedTo.name')
                    ->label('Assigned To')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Unassigned')
                    ->icon(fn ($record) => $record->assigned_to_id ? 'heroicon-o-user' : null),

                TextColumn::make('manufacturer')
                    ->label('Manufacturer')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('model')
                    ->label('Model')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('serial_number')
                    ->label('Serial Number')
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('location')
                    ->label('Location')
                    ->searchable()
                    ->icon('heroicon-o-map-pin')
                    ->toggleable(),

                TextColumn::make('department')
                    ->label('Department')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('warranty_expires')
                    ->label('Warranty')
                    ->date()
                    ->sortable()
                    ->badge()
                    ->color(function ($record) {
                        if (!$record->warranty_expires) {
                            return 'gray';
                        }

                        $daysRemaining = now()->diffInDays($record->warranty_expires, false);

                        if ($daysRemaining < 0) {
                            return 'danger'; // Expired
                        } elseif ($daysRemaining <= 30) {
                            return 'warning'; // Expiring soon
                        } else {
                            return 'success'; // Valid
                        }
                    })
                    ->formatStateUsing(function ($record) {
                        if (!$record->warranty_expires) {
                            return 'No warranty';
                        }

                        $daysRemaining = now()->diffInDays($record->warranty_expires, false);

                        if ($daysRemaining < 0) {
                            return 'Expired ' . abs($daysRemaining) . ' days ago';
                        } elseif ($daysRemaining <= 30) {
                            return 'Expires in ' . $daysRemaining . ' days';
                        } else {
                            return $record->warranty_expires->format('M d, Y');
                        }
                    })
                    ->toggleable(),

                TextColumn::make('purchase_date')
                    ->label('Purchase Date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('purchase_cost')
                    ->label('Purchase Cost')
                    ->money('USD')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-globe-alt')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('mac_address')
                    ->label('MAC Address')
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('deleted_at')
                    ->label('Deleted')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'in_storage' => 'In Storage',
                        'maintenance' => 'Maintenance',
                        'broken' => 'Broken',
                        'retired' => 'Retired',
                    ])
                    ->multiple()
                    ->label('Status'),

                SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->label('Category'),

                SelectFilter::make('assigned_to_id')
                    ->relationship('assignedTo', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->label('Assigned To'),

                SelectFilter::make('warranty_status')
                    ->options([
                        'valid' => 'Valid Warranty',
                        'expiring_soon' => 'Expiring Soon (30 days)',
                        'expired' => 'Expired',
                        'no_warranty' => 'No Warranty',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'] === 'valid',
                            fn (Builder $query) => $query->whereNotNull('warranty_expires')
                                ->whereDate('warranty_expires', '>', now()->addDays(30))
                        )->when(
                            $data['value'] === 'expiring_soon',
                            fn (Builder $query) => $query->whereNotNull('warranty_expires')
                                ->whereDate('warranty_expires', '<=', now()->addDays(30))
                                ->whereDate('warranty_expires', '>=', now())
                        )->when(
                            $data['value'] === 'expired',
                            fn (Builder $query) => $query->whereNotNull('warranty_expires')
                                ->whereDate('warranty_expires', '<', now())
                        )->when(
                            $data['value'] === 'no_warranty',
                            fn (Builder $query) => $query->whereNull('warranty_expires')
                        );
                    })
                    ->label('Warranty Status'),

                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('asset_tag', 'asc')
            ->striped()
            ->persistFiltersInSession()
            ->emptyStateHeading('No assets being tracked yet')
            ->emptyStateDescription('Start building your inventory by adding your first piece of equipment!')
            ->emptyStateIcon('heroicon-o-computer-desktop')
            ->emptyStateActions([
                \Filament\Actions\CreateAction::make()
                    ->label('Add First Asset')
                    ->icon('heroicon-o-plus-circle'),
            ]);
    }
}
