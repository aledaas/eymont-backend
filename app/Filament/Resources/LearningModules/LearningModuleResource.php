<?php

namespace App\Filament\Resources\LearningModules;

use App\Filament\Resources\LearningModules\Pages\CreateLearningModule;
use App\Filament\Resources\LearningModules\Pages\EditLearningModule;
use App\Filament\Resources\LearningModules\Pages\ListLearningModules;
use App\Filament\Resources\LearningModules\Pages\ViewLearningModule;
use App\Filament\Resources\LearningModules\Schemas\LearningModuleForm;
use App\Filament\Resources\LearningModules\Schemas\LearningModuleInfolist;
use App\Filament\Resources\LearningModules\Tables\LearningModulesTable;
use App\Modules\Content\Domain\Models\LearningModule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LearningModuleResource extends Resource
{
    protected static ?string $model = LearningModule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return LearningModuleForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LearningModuleInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LearningModulesTable::configure($table);
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
            'index' => ListLearningModules::route('/'),
            'create' => CreateLearningModule::route('/create'),
            'view' => ViewLearningModule::route('/{record}'),
            'edit' => EditLearningModule::route('/{record}/edit'),
        ];
    }
}
