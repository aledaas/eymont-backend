<?php

namespace App\Filament\Resources\ExerciseTemplates;

use App\Filament\Resources\ExerciseTemplates\Pages\CreateExerciseTemplate;
use App\Filament\Resources\ExerciseTemplates\Pages\EditExerciseTemplate;
use App\Filament\Resources\ExerciseTemplates\Pages\ListExerciseTemplates;
use App\Filament\Resources\ExerciseTemplates\Pages\ViewExerciseTemplate;
use App\Filament\Resources\ExerciseTemplates\Schemas\ExerciseTemplateForm;
use App\Filament\Resources\ExerciseTemplates\Schemas\ExerciseTemplateInfolist;
use App\Filament\Resources\ExerciseTemplates\Tables\ExerciseTemplatesTable;
use App\Models\ExerciseTemplate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ExerciseTemplateResource extends Resource
{
    protected static ?string $model = ExerciseTemplate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ExerciseTemplateForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ExerciseTemplateInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExerciseTemplatesTable::configure($table);
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
            'index' => ListExerciseTemplates::route('/'),
            'create' => CreateExerciseTemplate::route('/create'),
            'view' => ViewExerciseTemplate::route('/{record}'),
            'edit' => EditExerciseTemplate::route('/{record}/edit'),
        ];
    }
}
