<?php

namespace App\Filament\Resources\IoTResource\Pages;

use App\Filament\Resources\IoTResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateIoT extends CreateRecord
{
    public function getTitle(): string
    {
        return 'Tambah IoT';
    }

    protected static string $resource = IoTResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
