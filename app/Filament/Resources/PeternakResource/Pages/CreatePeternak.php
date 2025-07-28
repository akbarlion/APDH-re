<?php

namespace App\Filament\Resources\PeternakResource\Pages;

use Filament\Facades\Filament;
use App\Filament\Resources\PeternakResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePeternak extends CreateRecord
{
    protected static string $resource = PeternakResource::class;

    protected function afterCreate(): void
    {
        $this->record->profile()->update([
            'rph_id' => Filament::auth()->user()->profile?->rph_id
        ]);
    }
}
