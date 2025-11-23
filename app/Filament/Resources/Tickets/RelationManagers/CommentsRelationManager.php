<?php

namespace App\Filament\Resources\Tickets\RelationManagers;

use App\Models\CannedResponse;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    protected static ?string $recordTitleAttribute = 'comment';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('canned_response_id')
                    ->label('Use Canned Response (Optional)')
                    ->placeholder('Select a template to auto-fill...')
                    ->options(CannedResponse::active()->ordered()->pluck('title', 'id'))
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(function (?string $state, Set $set) {
                        if ($state) {
                            $response = CannedResponse::find($state);
                            if ($response) {
                                $set('comment', $response->content);
                                // Increment usage count
                                $response->incrementUsage();
                            }
                        }
                    })
                    ->dehydrated(false)
                    ->columnSpanFull(),

                Textarea::make('comment')
                    ->required()
                    ->label('Comment')
                    ->rows(6)
                    ->placeholder('Add a comment to this ticket...')
                    ->helperText('You can select a canned response above to auto-fill this field')
                    ->columnSpanFull(),

                Toggle::make('is_internal')
                    ->label('Internal Note')
                    ->helperText('Internal notes are only visible to IT staff')
                    ->default(false)
                    ->inline(false),

                Toggle::make('is_resolution')
                    ->label('Mark as Resolution')
                    ->helperText('This comment resolves the ticket')
                    ->default(false)
                    ->inline(false),

                TextInput::make('time_spent')
                    ->label('Time Spent (minutes)')
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->suffix('min')
                    ->helperText('Time spent working on this update'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('comment')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Author')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('comment')
                    ->label('Comment')
                    ->searchable()
                    ->limit(100)
                    ->wrap(),

                IconColumn::make('is_internal')
                    ->label('Internal')
                    ->boolean()
                    ->trueIcon('heroicon-o-lock-closed')
                    ->falseIcon('heroicon-o-user-group')
                    ->trueColor('warning')
                    ->falseColor('success')
                    ->tooltip(fn ($record) => $record->is_internal ? 'Internal Note' : 'Public Comment'),

                IconColumn::make('is_resolution')
                    ->label('Resolution')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('')
                    ->trueColor('success'),

                TextColumn::make('time_spent')
                    ->label('Time')
                    ->suffix(' min')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Posted')
                    ->dateTime()
                    ->sortable()
                    ->since(),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([
                CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['user_id'] = Auth::id();
                        return $data;
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
