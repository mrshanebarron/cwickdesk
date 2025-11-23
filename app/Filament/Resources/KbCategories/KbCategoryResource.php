<?php

namespace App\Filament\Resources\KbCategories;

use App\Filament\Resources\KbCategories\Pages\CreateKbCategory;
use App\Filament\Resources\KbCategories\Pages\EditKbCategory;
use App\Filament\Resources\KbCategories\Pages\ListKbCategories;
use App\Filament\Resources\KbCategories\Schemas\KbCategoryForm;
use App\Filament\Resources\KbCategories\Tables\KbCategoriesTable;
use App\Models\KbCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KbCategoryResource extends Resource
{
    protected static ?string $model = KbCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return KbCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KbCategoriesTable::configure($table);
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
            'index' => ListKbCategories::route('/'),
            'create' => CreateKbCategory::route('/create'),
            'edit' => EditKbCategory::route('/{record}/edit'),
        ];
    }
}
