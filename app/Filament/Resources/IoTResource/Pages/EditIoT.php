<?php

namespace App\Filament\Resources\IoTResource\Pages;

use App\Filament\Resources\IoTResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIoT extends EditRecord
{
    protected static string $resource = IoTResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
