<?php

namespace App\Filament\Resources\ErrorPatterns\Pages;

use App\Filament\Resources\ErrorPatterns\ErrorPatternResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditErrorPattern extends EditRecord
{
    protected static string $resource = ErrorPatternResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
