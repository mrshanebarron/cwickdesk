<?php

namespace App\Filament\Resources\Tickets\Schemas;

use App\Models\Asset;
use App\Models\TicketPriority;
use App\Models\TicketStatus;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Schemas\Schema;

class TicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Ticket Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('ticket_number')
                                    ->label('Ticket Number')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->placeholder('Auto-generated')
                                    ->helperText('Will be auto-generated on save'),

                                Select::make('source')
                                    ->label('Source')
                                    ->options([
                                        'web' => 'Web Form',
                                        'email' => 'Email',
                                        'phone' => 'Phone Call',
                                        'walk-in' => 'Walk-in',
                                    ])
                                    ->default('web')
                                    ->required(),
                            ]),

                        TextInput::make('subject')
                            ->label('Subject')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        RichEditor::make('description')
                            ->label('Description')
                            ->required()
                            ->toolbarButtons([
                                'bold',
                                'bulletList',
                                'orderedList',
                                'italic',
                                'link',
                                'redo',
                                'undo',
                            ])
                            ->columnSpanFull(),
                    ]),

                Section::make('Assignment & Priority')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('requester_id')
                                    ->label('Requester')
                                    ->relationship('requester', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        TextInput::make('name')
                                            ->required(),
                                        TextInput::make('email')
                                            ->email()
                                            ->required(),
                                    ]),

                                Select::make('assigned_to_id')
                                    ->label('Assigned To')
                                    ->relationship(
                                        'assignedTo',
                                        'name',
                                        fn ($query) => $query->where('is_agent', true)
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->placeholder('Unassigned'),

                                Select::make('priority_id')
                                    ->label('Priority')
                                    ->relationship('priority', 'name')
                                    ->required()
                                    ->default(function () {
                                        return TicketPriority::where('is_default', true)->first()?->id;
                                    }),

                                Select::make('status_id')
                                    ->label('Status')
                                    ->relationship('status', 'name')
                                    ->required()
                                    ->default(function () {
                                        return TicketStatus::where('is_default', true)->first()?->id;
                                    }),

                                Select::make('asset_id')
                                    ->label('Related Asset')
                                    ->relationship('asset', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->placeholder('No asset linked'),

                                DateTimePicker::make('due_date')
                                    ->label('Due Date')
                                    ->native(false)
                                    ->placeholder('No due date'),
                            ]),
                    ]),

                Section::make('Additional Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Toggle::make('is_internal')
                                    ->label('Internal Ticket')
                                    ->helperText('Not visible to end users')
                                    ->default(false),

                                TextInput::make('time_spent')
                                    ->label('Time Spent (minutes)')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->suffix('min'),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
