<?php

namespace App\Filament\Resources\NeuroTags\Pages;

use App\Filament\Resources\NeuroTags\NeuroTagResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditNeuroTag extends EditRecord
{
    protected static string $resource = NeuroTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
