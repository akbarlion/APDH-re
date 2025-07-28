<?php

namespace App\Filament\Resources\JulehaResource\Pages;

use Filament\Facades\Filament;
use App\Filament\Resources\JulehaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJuleha extends CreateRecord
{
    protected static string $resource = JulehaResource::class;

    protected function afterCreate(): void
    {
        $this->record->profile?->rphs()->attach(
            Filament::auth()->user()->profile?->rph_id
        );
    }
}
