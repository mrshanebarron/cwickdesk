<?php

namespace App\Filament\Resources\CannedResponses\Schemas;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class CannedResponseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Response Details')
                    ->schema([
                        TextInput::make('title')
                            ->label('Response Title')
                            ->required()
                            ->placeholder('e.g., Password Reset - Instructions Sent')
                            ->helperText('A short, descriptive title for this response')
                            ->columnSpanFull(),

                        Textarea::make('content')
                            ->label('Response Content')
                            ->required()
                            ->rows(8)
                            ->placeholder('Enter the response text here...')
                            ->helperText('Use [PLACEHOLDERS] for fields that need to be customized when using the response')
                            ->columnSpanFull(),

                        Grid::make(2)
                            ->schema([
                                Select::make('category')
                                    ->label('Category')
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
                                    ->searchable()
                                    ->placeholder('Select a category'),

                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->helperText('Inactive responses won\'t appear in the dropdown')
                                    ->default(true)
                                    ->inline(false),
                            ]),
                    ]),

                Section::make('Usage Statistics')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('usage_count')
                                    ->label('Times Used')
                                    ->numeric()
                                    ->default(0)
                                    ->disabled()
                                    ->dehydrated(false),

                                TextInput::make('creator.name')
                                    ->label('Created By')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->default(fn () => Auth::user()->name),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
