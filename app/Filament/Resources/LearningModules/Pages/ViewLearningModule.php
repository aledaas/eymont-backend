<?php

namespace App\Filament\Resources\LearningModules\Pages;

use App\Filament\Resources\LearningModules\LearningModuleResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLearningModule extends ViewRecord
{
    protected static string $resource = LearningModuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
