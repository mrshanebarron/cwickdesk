<?php

namespace App\Filament\Resources\KbArticles;

use App\Filament\Resources\KbArticles\Pages\CreateKbArticle;
use App\Filament\Resources\KbArticles\Pages\EditKbArticle;
use App\Filament\Resources\KbArticles\Pages\ListKbArticles;
use App\Filament\Resources\KbArticles\Pages\ViewKbArticle;
use App\Filament\Resources\KbArticles\Schemas\KbArticleForm;
use App\Filament\Resources\KbArticles\Schemas\KbArticleInfolist;
use App\Filament\Resources\KbArticles\Tables\KbArticlesTable;
use App\Models\KbArticle;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KbArticleResource extends Resource
{
    protected static ?string $model = KbArticle::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return KbArticleForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return KbArticleInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KbArticlesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKbArticles::route('/'),
            'create' => CreateKbArticle::route('/create'),
            'view' => ViewKbArticle::route('/{record}'),
            'edit' => EditKbArticle::route('/{record}/edit'),
        ];
    }
}
