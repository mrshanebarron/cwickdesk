<?php

namespace App\Filament\Platform\Resources\Tenants\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Support\Enums\IconSize;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class TenantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('domain')
                    ->searchable()
                    ->sortable()
                    ->url(fn($record) => 'https://' . $record->domain)
                    ->openUrlInNewTab(),
                TextColumn::make('plan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'free' => 'gray',
                        'starter' => 'info',
                        'professional' => 'warning',
                        'enterprise' => 'success',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'trial' => 'warning',
                        'suspended' => 'danger',
                        'cancelled' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),
                IconColumn::make('is_internal')
                    ->label('Internal')
                    ->boolean(),
                TextColumn::make('users_count')
                    ->label('Users')
                    ->getStateUsing(function ($record) {
                        return \App\Models\User::where('tenant_id', $record->id)->count();
                    }),
                TextColumn::make('contact_email')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('trial_ends_at')
                    ->label('Trial Ends')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('last_active_at')
                    ->label('Last Active')
                    ->dateTime('M d, Y g:i A')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                Action::make('visit_portal')
                    ->label('Visit Portal')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->iconSize(IconSize::Small)
                    ->url(fn ($record) => 'https://' . $record->domain)
                    ->openUrlInNewTab()
                    ->color('info'),
                Action::make('login_admin')
                    ->label('Login to Admin')
                    ->icon('heroicon-o-lock-open')
                    ->iconSize(IconSize::Small)
                    ->url(fn ($record) => 'https://' . $record->domain . '/admin')
                    ->openUrlInNewTab()
                    ->color('success'),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
