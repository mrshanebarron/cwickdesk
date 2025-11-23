<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Full Name')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('email')
                                    ->label('Email Address')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('password')
                                    ->password()
                                    ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                                    ->dehydrated(fn ($state) => filled($state))
                                    ->required(fn (string $context): bool => $context === 'create')
                                    ->helperText('Leave blank to keep current password'),

                                DateTimePicker::make('email_verified_at')
                                    ->label('Email Verified At')
                                    ->native(false),
                            ]),
                    ]),

                Section::make('Roles & Permissions')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('roles')
                                    ->label('Role')
                                    ->relationship('roles', 'name')
                                    ->multiple()
                                    ->preload()
                                    ->searchable()
                                    ->helperText('Select one or more roles for this user'),

                                Grid::make(2)
                                    ->schema([
                                        Toggle::make('is_admin')
                                            ->label('Admin Flag')
                                            ->helperText('Legacy admin flag')
                                            ->default(false),

                                        Toggle::make('is_agent')
                                            ->label('Agent Flag')
                                            ->helperText('Legacy agent flag')
                                            ->default(false),
                                    ]),
                            ]),
                    ]),

                Section::make('Phone Directory')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('extension')
                                    ->label('Extension')
                                    ->maxLength(50),

                                TextInput::make('direct')
                                    ->label('Direct Line')
                                    ->tel()
                                    ->maxLength(50),

                                TextInput::make('cell')
                                    ->label('Cell Phone')
                                    ->tel()
                                    ->maxLength(50),
                            ]),

                        Grid::make(3)
                            ->schema([
                                TextInput::make('building')
                                    ->label('Building')
                                    ->maxLength(100),

                                TextInput::make('department')
                                    ->label('Department')
                                    ->maxLength(100),

                                TextInput::make('area_of_responsibility')
                                    ->label('Area of Responsibility')
                                    ->maxLength(255),
                            ]),
                    ])
                    ->collapsible(),

                Section::make('SSO Configuration')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('sso_provider')
                                    ->label('SSO Provider')
                                    ->maxLength(50)
                                    ->placeholder('microsoft, google, etc.'),

                                TextInput::make('sso_id')
                                    ->label('SSO ID')
                                    ->maxLength(255),
                            ]),

                        DateTimePicker::make('last_sso_sync')
                            ->label('Last SSO Sync')
                            ->native(false)
                            ->disabled(),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
