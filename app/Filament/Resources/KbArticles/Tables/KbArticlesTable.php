<?php

namespace App\Filament\Resources\KbArticles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class KbArticlesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->weight('bold'),

                BadgeColumn::make('category.name')
                    ->label('Category')
                    ->colors(['primary']),

                TextColumn::make('author.name')
                    ->label('Author')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray')
                    ->toggleable(),

                TextColumn::make('view_count')
                    ->label('Views')
                    ->numeric()
                    ->sortable()
                    ->alignEnd()
                    ->toggleable(),

                TextColumn::make('feedback_count')
                    ->label('Feedback')
                    ->getStateUsing(fn ($record) => $record->feedback()->count())
                    ->badge()
                    ->color('gray')
                    ->alignEnd()
                    ->toggleable()
                    ->tooltip('Total feedback submissions'),

                TextColumn::make('helpful_percentage')
                    ->label('Helpful %')
                    ->getStateUsing(fn ($record) => $record->helpfulPercentage() . '%')
                    ->badge()
                    ->color(function ($record) {
                        $percentage = $record->helpfulPercentage();
                        if ($percentage >= 80) return 'success';
                        if ($percentage >= 50) return 'warning';
                        return 'danger';
                    })
                    ->alignEnd()
                    ->toggleable()
                    ->tooltip(fn ($record) =>
                        $record->helpfulCount() . ' helpful / ' .
                        $record->notHelpfulCount() . ' not helpful'
                    ),

                TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->preload()
                    ->multiple(),

                SelectFilter::make('author')
                    ->relationship('author', 'name')
                    ->preload()
                    ->searchable(),

                Filter::make('published')
                    ->query(fn (Builder $query): Builder => $query->where('is_published', true))
                    ->toggle()
                    ->default(),

                Filter::make('featured')
                    ->query(fn (Builder $query): Builder => $query->where('is_featured', true))
                    ->toggle(),

                Filter::make('drafts')
                    ->query(fn (Builder $query): Builder => $query->where('is_published', false))
                    ->toggle(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Knowledge base is empty')
            ->emptyStateDescription('Start documenting your processes and procedures by creating your first article!')
            ->emptyStateIcon('heroicon-o-book-open')
            ->emptyStateActions([
                \Filament\Actions\CreateAction::make()
                    ->label('Write First Article')
                    ->icon('heroicon-o-plus-circle'),
            ]);
    }
}
