<?php

namespace App\Filament\Resources\LapakResource\Pages;

use App\Filament\Resources\LapakResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLapak extends EditRecord
{
    protected static string $resource = LapakResource::class;

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
