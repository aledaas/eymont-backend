<?php

namespace App\Filament\Resources\ErrorPatterns\Pages;

use App\Filament\Resources\ErrorPatterns\ErrorPatternResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewErrorPattern extends ViewRecord
{
    protected static string $resource = ErrorPatternResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
