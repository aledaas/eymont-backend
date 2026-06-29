<?php

namespace App\Filament\Resources\NeuroTags;

use App\Filament\Resources\NeuroTags\Pages\CreateNeuroTag;
use App\Filament\Resources\NeuroTags\Pages\EditNeuroTag;
use App\Filament\Resources\NeuroTags\Pages\ListNeuroTags;
use App\Filament\Resources\NeuroTags\Pages\ViewNeuroTag;
use App\Filament\Resources\NeuroTags\Schemas\NeuroTagForm;
use App\Filament\Resources\NeuroTags\Schemas\NeuroTagInfolist;
use App\Filament\Resources\NeuroTags\Tables\NeuroTagsTable;
use App\Models\NeuroTag;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class NeuroTagResource extends Resource
{
    protected static ?string $model = NeuroTag::class;

    protected static string|BackedEnum|null $navigationIcon =

        Heroicon::OutlinedTag;

    protected static ?string $navigationLabel = 'Neuro Tags';

    protected static ?string $modelLabel = 'Neuro Tag';

    protected static ?string $pluralModelLabel = 'Neuro Tags';

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 100;

    public static function form(Schema $schema): Schema
    {
        return NeuroTagForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return NeuroTagInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NeuroTagsTable::configure($table);
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
            'index' => ListNeuroTags::route('/'),
            'create' => CreateNeuroTag::route('/create'),
            'view' => ViewNeuroTag::route('/{record}'),
            'edit' => EditNeuroTag::route('/{record}/edit'),
        ];
    }
}
