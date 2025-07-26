<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Facades\Filament;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    /*
     * Add rph_id before create
     * @return array
     */
    protected function afterCreate(): void
    {
        $this->record->profile->update([
            'rph_id' => Filament::auth()->user()->profile?->rph_id
        ]);
    }
}
