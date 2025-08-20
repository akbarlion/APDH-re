<?php

namespace App\Filament\Resources\LapakResource\Pages;

use App\Filament\Resources\LapakResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLapaks extends ListRecords
{
    protected static string $resource = LapakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
