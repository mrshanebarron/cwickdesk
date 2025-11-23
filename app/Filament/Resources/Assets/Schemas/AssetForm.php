<?php

namespace App\Filament\Resources\Assets\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('asset_tag')
                                    ->label('Asset Tag')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('DF-LT-001')
                                    ->helperText('Unique identifier for this asset'),

                                TextInput::make('name')
                                    ->required()
                                    ->placeholder('Dell Latitude 5520')
                                    ->helperText('Asset name or model description'),
                            ]),

                        Textarea::make('description')
                            ->rows(3)
                            ->placeholder('Additional details about this asset...')
                            ->columnSpanFull(),

                        Select::make('category_id')
                            ->label('Category')
                            ->relationship('category', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('name')->required(),
                                Textarea::make('description'),
                            ]),
                    ]),

                Section::make('Asset Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('manufacturer')
                                    ->placeholder('Dell, HP, Apple, etc.'),

                                TextInput::make('model')
                                    ->placeholder('Latitude 5520, EliteBook 840'),

                                TextInput::make('serial_number')
                                    ->placeholder('S/N: ABC123456'),

                                Select::make('status')
                                    ->required()
                                    ->default('active')
                                    ->options([
                                        'active' => 'Active',
                                        'in_storage' => 'In Storage',
                                        'maintenance' => 'Maintenance',
                                        'broken' => 'Broken',
                                        'retired' => 'Retired',
                                    ])
                                    ->native(false),
                            ]),
                    ]),

                Section::make('Network Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('mac_address')
                                    ->label('MAC Address')
                                    ->placeholder('00:1B:44:11:3A:B7'),

                                TextInput::make('ip_address')
                                    ->label('IP Address')
                                    ->placeholder('192.168.1.100'),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make('Assignment')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('assigned_to_id')
                                    ->label('Assigned To')
                                    ->relationship('assignedTo', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->placeholder('Select user...'),

                                TextInput::make('location')
                                    ->placeholder('Building A, Floor 2'),

                                TextInput::make('department')
                                    ->placeholder('IT, Sales, Marketing'),
                            ]),
                    ]),

                Section::make('Lifecycle & Warranty')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                DatePicker::make('purchase_date')
                                    ->label('Purchase Date')
                                    ->native(false),

                                TextInput::make('purchase_cost')
                                    ->label('Purchase Cost')
                                    ->numeric()
                                    ->prefix('$')
                                    ->placeholder('0.00'),

                                DatePicker::make('warranty_expires')
                                    ->label('Warranty Expires')
                                    ->native(false)
                                    ->afterOrEqual('purchase_date'),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make('Additional Information')
                    ->schema([
                        Textarea::make('notes')
                            ->rows(4)
                            ->placeholder('Internal notes, maintenance history, etc.')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
