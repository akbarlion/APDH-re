<?php

namespace App\Filament\Resources\RphResource\Pages;

use App\Filament\Resources\RphResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRph extends EditRecord
{
    protected static string $resource = RphResource::class;

    public function getTitle(): string
    {
        return 'Edit RPH';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
