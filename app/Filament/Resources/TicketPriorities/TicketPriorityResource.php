<?php

namespace App\Filament\Resources\TicketPriorities;

use App\Filament\Resources\TicketPriorities\Pages\CreateTicketPriority;
use App\Filament\Resources\TicketPriorities\Pages\EditTicketPriority;
use App\Filament\Resources\TicketPriorities\Pages\ListTicketPriorities;
use App\Filament\Resources\TicketPriorities\Schemas\TicketPriorityForm;
use App\Filament\Resources\TicketPriorities\Tables\TicketPrioritiesTable;
use App\Models\TicketPriority;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TicketPriorityResource extends Resource
{
    protected static ?string $model = TicketPriority::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return TicketPriorityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TicketPrioritiesTable::configure($table);
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
            'index' => ListTicketPriorities::route('/'),
            'create' => CreateTicketPriority::route('/create'),
            'edit' => EditTicketPriority::route('/{record}/edit'),
        ];
    }
}
