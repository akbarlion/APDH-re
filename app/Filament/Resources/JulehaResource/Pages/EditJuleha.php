<?php

namespace App\Filament\Resources\JulehaResource\Pages;

use App\Filament\Resources\JulehaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJuleha extends EditRecord
{
    protected static string $resource = JulehaResource::class;

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
