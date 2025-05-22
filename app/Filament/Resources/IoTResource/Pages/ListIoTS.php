<?php

namespace App\Filament\Resources\IoTResource\Pages;

use App\Filament\Resources\IoTResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIoTS extends ListRecords
{
    protected static string $resource = IoTResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
