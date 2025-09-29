<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /*
     * Add rph_id before create
     * @return array
     */
    protected function afterCreate(): void
    {
        if ($this->record->role == 'penyelia') {
            $this->record->profile->update([
                'rph_id' => Filament::auth()->user()->profile?->rph_id,
            ]);
        }
    }
}
