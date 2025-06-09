<?php

namespace App\Filament\Resources\JulehaResource\Pages;

use App\Filament\Resources\JulehaResource;
use Filament\Forms;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Juleha;

class ListJulehas extends ListRecords
{
    protected static string $resource = JulehaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('findOrCreate')
                ->label('New Juleha')
                ->modalHeading('Tambah Juleha')
                ->form([
                    Forms\Components\TextInput::make('nomor_sertifikat')
                        ->label('Nomor Sertifikat Juleha')
                        ->required()
                        ->live(debounce: 500)
                        ->afterStateUpdated(function ($state, callable $set) {
                            $exists = Juleha::where('nomor_sertifikat', $state)->exists();
                            $set('exists', $exists);
                        }),

                        Forms\Components\Placeholder::make('existsMessage')
                            ->label('')
                            ->content(function ($get) {
                                if ($get('nomor_sertifikat') === null) return null;
                                return $get('exists')
                                    ? '✅ Juleha exists and will be linked.'
                                    : '🆕 No Juleha found. You will create a new one.';
                            }),
                ])
                ->action(function (array $data): void {
                    $nomor_sertifikat = $data['nomor_sertifikat'];
                    $juleha = \App\Models\Juleha::where('nomor_sertifikat', $nomor_sertifikat)->first();
                    $rph_admin = auth()->user()->profile;

                    if ($juleha) {
                        // Already exists → Link if not already linked
                        if (! $juleha->rphs()->where('rph_id', $rph_admin->rph_id)->exists()) {
                            $juleha->rphs()->attach($rph_admin->rph_id);
                        }

                        \Filament\Notifications\Notification::make()
                            ->title('Juleha linked successfully.')
                            ->success()
                            ->send();

                        return;
                    }

                    // Not found → redirect to create page with identifier prefilled
                    redirect(\App\Filament\Resources\JulehaResource::getUrl('create', [
                        'nomor_sertifikat' => $nomor_sertifikat,
                    ]));
                })

        ];
    }
}
