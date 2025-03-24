<?php

namespace App\Filament\Resources\RphResource\Pages;

use App\Filament\Resources\RphResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRphs extends ListRecords
{
    protected static string $resource = RphResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('New RPH'),
        ];
    }
}
