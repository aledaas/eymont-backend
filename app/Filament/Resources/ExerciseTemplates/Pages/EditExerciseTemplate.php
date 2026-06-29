<?php

namespace App\Filament\Resources\ExerciseTemplates\Pages;

use App\Filament\Resources\ExerciseTemplates\ExerciseTemplateResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditExerciseTemplate extends EditRecord
{
    protected static string $resource = ExerciseTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
