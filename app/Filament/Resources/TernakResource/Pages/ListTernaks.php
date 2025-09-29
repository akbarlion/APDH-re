<?php

namespace App\Filament\Resources\TernakResource\Pages;

use App\Filament\Resources\TernakResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTernaks extends ListRecords
{
    protected static string $resource = TernakResource::class;

    public function getTitle(): string
    {
        return 'Ternak';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
