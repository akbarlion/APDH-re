<?php

namespace App\Filament\Resources\PeternakResource\Pages;

use App\Filament\Resources\PeternakResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeternaks extends ListRecords
{
    protected static string $resource = PeternakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
