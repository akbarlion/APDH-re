<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeternakResource\Pages;
use App\Filament\Resources\PeternakResource\RelationManagers;
use App\Models\Peternak;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PeternakResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Peternak';
    protected static ?string $label = 'Peternak';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->columnSpan(['xl' => 3])
                    ->label('Nama Lengkap')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->columnSpan(['xl' => 3])
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->columnSpan(['xl' => 3])
                    ->password()
                    ->confirmed()
                    ->required(),
                Forms\Components\TextInput::make('password_confirmation')
                    ->columnSpan(['xl' => 3])
                    ->password()
                    ->required()
                    ->maxLength(255)
                    ->same('password')
                    ->dehydrated(false)
                    ->label('Confirm Password'),
                Forms\Components\TextInput::make('phone')
                    ->columnSpan(['xl' => 3])
                    ->label('No Telp'),
                Forms\Components\Textarea::make('alamat')
                    ->columnSpan(['xl' => 3]),
                Forms\Components\Hidden::make('role')
                    ->default('peternak'),
                Forms\Components\Fieldset::make('Keterangan')
                    ->relationship('profile')
                    ->schema([
                        Forms\Components\Select::make('status_usaha')
                            ->label('Status Usaha')
                            ->native(false)
                            ->options([
                                'Belum Terdaftar' => 'Belum Terdaftar',
                                'Terdaftar' => 'Terdaftar'
                            ])
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label("Nama"),
                Tables\Columns\TextColumn::make('user.alamat')
                    ->label("Alamat"),
                Tables\Columns\TextColumn::make('status_usaha')
                    ->label("Status Usaha"),
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
            'index' => Pages\ListPeternaks::route('/'),
            'create' => Pages\CreatePeternak::route('/create'),
            'edit' => Pages\EditPeternak::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->role == 'admin_rph';
    }


    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        if (!$user ||!$user->profile ||!$user->profile->rph_id) {
            return parent::getEloquentQuery()->whereRaw('1 = 0');
        }

        /*
        $userIds = Peternak::where('rph_id', $user->profile?->rph_id)
            ->pluck('user_id');

        return User::whereIn('id', $userIds);
         */
        if (request()->routeIs('filament.admin.resources.peternaks.edit')) {
            return parent::getEloquentQuery(); // or your safe fallback
        }

        return Peternak::with('user')
            ->where('rph_id', $user->profile->rph_id);
    }
}
