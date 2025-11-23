<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class WarrantyAlertsWidget extends TableWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Asset::query()
                    ->whereNotNull('warranty_expires')
                    ->where('status', '!=', 'retired')
                    ->where(function ($query) {
                        $query->whereDate('warranty_expires', '<=', now()->addDays(90))
                              ->whereDate('warranty_expires', '>=', now());
                    })
                    ->orWhere(function ($query) {
                        $query->whereDate('warranty_expires', '<', now())
                              ->where('status', '!=', 'retired');
                    })
                    ->orderBy('warranty_expires', 'asc')
            )
            ->columns([
                TextColumn::make('asset_tag')
                    ->label('Asset Tag')
                    ->weight('bold')
                    ->color('primary'),

                TextColumn::make('name')
                    ->label('Asset Name')
                    ->searchable()
                    ->limit(40),

                TextColumn::make('assignedTo.name')
                    ->label('Assigned To')
                    ->placeholder('Unassigned'),

                TextColumn::make('warranty_expires')
                    ->label('Warranty Status')
                    ->badge()
                    ->color(function ($record) {
                        $daysRemaining = now()->diffInDays($record->warranty_expires, false);

                        if ($daysRemaining < 0) {
                            return 'danger';
                        } elseif ($daysRemaining <= 30) {
                            return 'danger';
                        } elseif ($daysRemaining <= 60) {
                            return 'warning';
                        } else {
                            return 'info';
                        }
                    })
                    ->formatStateUsing(function ($record) {
                        $daysRemaining = now()->diffInDays($record->warranty_expires, false);

                        if ($daysRemaining < 0) {
                            return 'EXPIRED ' . abs($daysRemaining) . ' days ago';
                        } elseif ($daysRemaining == 0) {
                            return 'Expires TODAY';
                        } elseif ($daysRemaining <= 30) {
                            return $daysRemaining . ' days - URGENT';
                        } else {
                            return $daysRemaining . ' days';
                        }
                    }),

                TextColumn::make('purchase_date')
                    ->label('Purchased')
                    ->date()
                    ->sortable(),
            ])
            ->defaultSort('warranty_expires', 'asc')
            ->emptyStateHeading('No Warranty Alerts')
            ->emptyStateDescription('All assets have valid warranties or no warranty information.')
            ->emptyStateIcon('heroicon-o-shield-check');
    }

    public function getTableHeading(): ?string
    {
        $count = Asset::whereNotNull('warranty_expires')
            ->where('status', '!=', 'retired')
            ->where(function ($query) {
                $query->whereDate('warranty_expires', '<=', now()->addDays(90));
            })
            ->orWhere(function ($query) {
                $query->whereDate('warranty_expires', '<', now())
                      ->where('status', '!=', 'retired');
            })
            ->count();

        return $count > 0
            ? "⚠️ Warranty Alerts ({$count} assets need attention)"
            : '✅ Warranty Alerts';
    }

    public function getTableDescription(): ?string
    {
        return 'Assets with warranties expiring in next 90 days or already expired. Renew warranties or plan replacements.';
    }
}
