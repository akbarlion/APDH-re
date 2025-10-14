<?php

namespace App\Filament\Resources\PeternakResource\Pages;

use App\Filament\Resources\PeternakResource;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreatePeternak extends CreateRecord
{
    public function getTitle(): string
    {
        return 'Tambah IoT';
    }

    protected static string $resource = PeternakResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $this->record
            ->profile()
            ->update([
                'rph_id' => Filament::auth()->user()->profile?->rph_id,
            ]);
    }
}
