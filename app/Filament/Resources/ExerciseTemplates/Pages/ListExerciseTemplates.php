<?php

namespace App\Filament\Resources\ExerciseTemplates\Pages;

use App\Filament\Resources\ExerciseTemplates\ExerciseTemplateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExerciseTemplates extends ListRecords
{
    protected static string $resource = ExerciseTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
