<?php

namespace App\Filament\Resources\KbArticles\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class KbArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Article Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('category_id')
                                    ->label('Category')
                                    ->relationship('category', 'name')
                                    ->required()
                                    ->preload()
                                    ->searchable()
                                    ->createOptionForm([
                                        TextInput::make('name')->required(),
                                        Textarea::make('description'),
                                        TextInput::make('slug')
                                            ->required()
                                            ->unique(),
                                    ]),

                                Select::make('author_id')
                                    ->label('Author')
                                    ->relationship('author', 'name')
                                    ->default(auth()->id())
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                            ]),

                        TextInput::make('title')
                            ->label('Title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                                if (! $get('slug')) {
                                    $set('slug', Str::slug($state));
                                }
                            })
                            ->columnSpanFull(),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('URL-friendly version of the title')
                            ->columnSpanFull(),

                        Textarea::make('excerpt')
                            ->label('Excerpt')
                            ->rows(2)
                            ->maxLength(500)
                            ->helperText('Brief summary shown in article lists')
                            ->columnSpanFull(),

                        RichEditor::make('content')
                            ->label('Content')
                            ->required()
                            ->toolbarButtons([
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->columnSpanFull(),

                        TagsInput::make('tags')
                            ->label('Tags')
                            ->placeholder('Add tags...')
                            ->helperText('Press enter after each tag')
                            ->columnSpanFull(),
                    ]),

                Section::make('Publishing')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Toggle::make('is_published')
                                    ->label('Published')
                                    ->default(false)
                                    ->helperText('Make this article visible'),

                                Toggle::make('is_featured')
                                    ->label('Featured')
                                    ->default(false)
                                    ->helperText('Show in featured articles'),

                                DateTimePicker::make('published_at')
                                    ->label('Published Date')
                                    ->native(false)
                                    ->default(now()),
                            ]),
                    ]),
            ]);
    }
}
