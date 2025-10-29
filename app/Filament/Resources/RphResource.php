<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RphResource\Pages;
use App\Filament\Resources\RphResource\RelationManagers;
use App\Models\Penyelia;
use App\Models\Rph;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RphResource extends Resource
{
    protected static null|string $model = Rph::class;

    protected static null|string $navigationIcon = 'heroicon-o-home-modern';
    protected static null|string $navigationLabel = 'RPH';
    protected static null|string $breadcrumb = 'PRH';

    // nav order
    protected static null|int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            Forms\Components\TextInput::make('alamat')->required()->maxLength(255),
            Forms\Components\TextInput::make('phone')->required()->maxLength(20), // Adjust length as needed
            Forms\Components\Select::make('status_sertifikasi')
                ->options([
                    'sudah' => 'Sudah',
                    'belum' => 'Belum',
                ])
                ->required(),
            Forms\Components\FileUpload::make('file_sertifikasi')
                ->nullable()
                ->directory('sertifikat_rph')
                ->acceptedFileTypes(['application/pdf', 'image/*']) // Adjust file types as needed
                ->maxSize(1024), // 1MB max file size. Adjust as needed.
            Forms\Components\Select::make('penyelia_id')
                ->native(false)
                // OLD CODE - shows all penyelia from all RPH (inconsistent with UserResource)
                // ->options(function () {
                //     $options = User::where('role', 'penyelia') // 👈 filter by role here
                //         ->get()
                //         ->mapWithKeys(fn($user) => [$user->id => $user->name])
                //         ->toArray();
                //     return $options;
                // })
                // NEW CODE - filter penyelia based on current user's RPH using direct table query
                ->options(function () {
                    $currentUser = auth()->user();
                    $rphId = $currentUser->profile?->rph_id;

                    if (!$rphId) {
                        return [];
                    }

                    // Get penyelia from the same RPH using direct table join
                    $options = User::where('role', 'penyelia')
                        ->whereIn('id', function ($query) use ($rphId) {
                        $query->select('user_id')
                            ->from('penyelia')
                            ->where('rph_id', $rphId);
                    })
                        ->get()
                        ->mapWithKeys(fn($user) => [$user->id => $user->name])
                        ->toArray();
                    return $options;
                })
                ->default(function ($record) {
                    if ($record && $record->penyelia_id) {
                        return $record->penyelia_id;
                    }
                    return null; // No default if no linked RPH
                })
                ->disabled(function ($get, $state) {
                    $currentUser = auth()->user();
                    $rphId = $currentUser->profile?->rph_id;

                    if (!$rphId) {
                        return true;
                    }

                    // Count penyelia using direct table query
                    $penyeliaCount = User::where('role', 'penyelia')
                        ->whereIn('id', function ($query) use ($rphId) {
                        $query->select('user_id')
                            ->from('penyelia')
                            ->where('rph_id', $rphId);
                    })
                        ->count();

                    return $penyeliaCount === 0;
                })
                ->hint(function ($state) {
                    $currentUser = auth()->user();
                    $rphId = $currentUser->profile?->rph_id;

                    if (!$rphId) {
                        return 'User tidak memiliki RPH yang terkait.';
                    }

                    // Count penyelia using direct table query
                    $penyeliaCount = User::where('role', 'penyelia')
                        ->whereIn('id', function ($query) use ($rphId) {
                        $query->select('user_id')
                            ->from('penyelia')
                            ->where('rph_id', $rphId);
                    })
                        ->count();

                    if ($penyeliaCount === 0) {
                        return 'Belum ada Penyelia untuk RPH ini. Tambahkan Penyelia terlebih dahulu.';
                    }
                    return null;
                })
                ->nullable(),
        ]);
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()->label('Add RPH')->formId('form'),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama RPH')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->label('Alamat')
                    ->searchable()
                    ->limit(50), // Limit text length for better display
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telepon')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('status_sertifikasi')
                    ->label('Status Sertifikasi')
                    ->colors([
                        'success' => 'sudah',
                        'warning' => 'belum',
                    ])
                    ->formatStateUsing(fn(string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('penyelia.name')
                    ->label('Penyelia')
                    ->default('Belum ditentukan')
                    ->searchable(),
                // OLD CODE - IconColumn doesn't have formatStateUsing method
                // Tables\Columns\IconColumn::make('file_sertifikasi')
                //     ->label('File Sertifikat')
                //     ->boolean()
                //     ->trueIcon('heroicon-o-document-check')
                //     ->falseIcon('heroicon-o-document-minus')
                //     ->formatStateUsing(fn ($state): bool => !empty($state)),
                // NEW CODE - Use TextColumn with icon display instead
                Tables\Columns\TextColumn::make('file_sertifikasi')
                    ->label('File Sertifikat')
                    ->formatStateUsing(fn($state): string => !empty($state) ? 'Ada' : 'Tidak ada')
                    ->badge()
                    ->color(fn($state): string => !empty($state) ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // OLD CODE - only showing name
                // Tables\Columns\TextColumn::make('name')->searchable(),
                // //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRphs::route('/'),
            'create' => Pages\CreateRph::route('/create'),
            'edit' => Pages\EditRph::route('/{record}/edit'),
        ];
    }
}
