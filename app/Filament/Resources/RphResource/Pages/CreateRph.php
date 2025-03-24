<?php

namespace App\Filament\Resources\RphResource\Pages;

use App\Filament\Resources\RphResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRph extends CreateRecord
{
    protected static string $resource = RphResource::class;

    public function getTitle(): string
    {
        return 'Edit RPH';
    }
}
