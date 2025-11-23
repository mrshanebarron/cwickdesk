<?php

namespace App\Filament\Resources\KbCategories\Pages;

use App\Filament\Resources\KbCategories\KbCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKbCategories extends ListRecords
{
    protected static string $resource = KbCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
