<?php

namespace App\Filament\Resources\ErrorPatterns;

use App\Domain\Content\Models\ErrorPattern;
use App\Filament\Resources\ErrorPatterns\Pages\CreateErrorPattern;
use App\Filament\Resources\ErrorPatterns\Pages\EditErrorPattern;
use App\Filament\Resources\ErrorPatterns\Pages\ListErrorPatterns;
use App\Filament\Resources\ErrorPatterns\Pages\ViewErrorPattern;
use App\Filament\Resources\ErrorPatterns\Schemas\ErrorPatternForm;
use App\Filament\Resources\ErrorPatterns\Schemas\ErrorPatternInfolist;
use App\Filament\Resources\ErrorPatterns\Tables\ErrorPatternsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ErrorPatternResource extends Resource
{
    protected static ?string $model = ErrorPattern::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ErrorPatternForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ErrorPatternInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ErrorPatternsTable::configure($table);
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
            'index' => ListErrorPatterns::route('/'),
            'create' => CreateErrorPattern::route('/create'),
            'view' => ViewErrorPattern::route('/{record}'),
            'edit' => EditErrorPattern::route('/{record}/edit'),
        ];
    }
}
