<?php

namespace App\Filament\Resources\JulehaResource\Pages;

use App\Filament\Resources\JulehaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJulehas extends ListRecords
{
    protected static string $resource = JulehaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
