<?php

namespace App\Filament\Resources\NeuroTags\Pages;

use App\Filament\Resources\NeuroTags\NeuroTagResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNeuroTags extends ListRecords
{
    protected static string $resource = NeuroTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
