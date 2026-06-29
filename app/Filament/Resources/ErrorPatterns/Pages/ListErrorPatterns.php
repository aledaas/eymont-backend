<?php

namespace App\Filament\Resources\ErrorPatterns\Pages;

use App\Filament\Resources\ErrorPatterns\ErrorPatternResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListErrorPatterns extends ListRecords
{
    protected static string $resource = ErrorPatternResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
