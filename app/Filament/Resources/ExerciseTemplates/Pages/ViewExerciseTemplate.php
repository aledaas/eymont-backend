<?php

namespace App\Filament\Resources\ExerciseTemplates\Pages;

use App\Filament\Resources\ExerciseTemplates\ExerciseTemplateResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewExerciseTemplate extends ViewRecord
{
    protected static string $resource = ExerciseTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
