<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RphResource\Pages;
use App\Filament\Resources\RphResource\RelationManagers;
use App\Models\Rph;
use App\Models\Penyelia;
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
    protected static ?string $model = Rph::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationLabel = 'RPH';

    // nav order
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('alamat')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('phone')
                ->required()
                ->maxLength(20), // Adjust length as needed
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
                ->options(function () {
                    $penyelias = User::where('role', 'penyelia')
                        ->with('profile')
                        ->get();

                    $options = [];
                    foreach ($penyelias as $penyelia) {
                        if ($penyelia->profile) {
                            $options[$penyelia->id] = $penyelia->profile->name;
                        }
                    }
                    return $options;
                    }) 
                ->default(function ($record) {
                    if ($record && $record->penyelia_id) {
                        return $record->penyelia_id;
                    }
                    return null; // No default if no linked RPH
                })
                ->disabled(function ($get, $state) {
                    return Penyelia::count() === 0;
                })
                ->hint(function ($state) {
                    if (Penyelia::count() === 0) {
                        return 'Please add Penyelia first.';
                    }
                    return null;
                })
                ->nullable(),
            ]);
    }

     protected function getFormActions(): array
     {
         return [
              $this->getCreateFormAction()
                ->label('Add RPH')
                ->formId('form'),
         ];
     }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                //
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
