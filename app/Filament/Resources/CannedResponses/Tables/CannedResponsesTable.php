<?php

namespace App\Filament\Resources\CannedResponses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CannedResponsesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record) => \Str::limit($record->content, 100)),

                TextColumn::make('category')
                    ->label('Category')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'Password Reset' => 'warning',
                        'Network' => 'info',
                        'Email' => 'success',
                        'Hardware' => 'danger',
                        'General' => 'gray',
                        default => 'primary',
                    }),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->sortable(),

                TextColumn::make('usage_count')
                    ->label('Usage Count')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->tooltip('Number of times this response has been used'),

                TextColumn::make('creator.name')
                    ->label('Created By')
                    ->sortable()
                    ->toggleable()
                    ->placeholder('System'),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->options([
                        'General' => 'General',
                        'Password Reset' => 'Password Reset',
                        'Network' => 'Network',
                        'Email' => 'Email',
                        'Software' => 'Software',
                        'Hardware' => 'Hardware',
                        'Printer' => 'Printer',
                        'Access' => 'Access',
                        'Remote Access' => 'Remote Access',
                    ])
                    ->multiple(),

                SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('duplicate')
                    ->icon('heroicon-o-document-duplicate')
                    ->action(function ($record) {
                        $newRecord = $record->replicate();
                        $newRecord->title = $record->title . ' (Copy)';
                        $newRecord->usage_count = 0;
                        $newRecord->created_by = \Auth::id();
                        $newRecord->save();
                    })
                    ->requiresConfirmation()
                    ->successNotificationTitle('Response duplicated successfully'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('usage_count', 'desc')
            ->striped();
    }
}
