<?php

namespace App\Filament\Resources\PeternakResource\Pages;

use App\Filament\Resources\PeternakResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeternak extends EditRecord
{
    protected static string $resource = PeternakResource::class;

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
