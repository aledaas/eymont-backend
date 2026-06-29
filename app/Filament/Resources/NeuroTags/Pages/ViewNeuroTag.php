<?php

namespace App\Filament\Resources\NeuroTags\Pages;

use App\Filament\Resources\NeuroTags\NeuroTagResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewNeuroTag extends ViewRecord
{
    protected static string $resource = NeuroTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
