<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JulehaResource\Pages;
use App\Filament\Resources\JulehaResource\RelationManagers;

use App\Models\Juleha;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JulehaResource extends Resource
{
    protected static ?string $model = Juleha::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nomor_sertifikat')
                    ->columnSpan(['xl' => 3])
                    ->label('Nomor Sertifikat'),
                TextInput::make('masa_sertifikat')
                    ->columnSpan(['xl' => 3])
                    ->label('Masa Berlaku'),
                TextInput::make('upload_sertifikat')
                    ->columnSpan(['xl' => 3])
                    ->label('Upload Sertifikat'),
                Fieldset::make('User')
                    ->relationship('user')
                    ->schema([
                        TextInput::make('name')
                            ->columnSpan(['xl' => 3])
                            ->label('Nama Lengkap')
                            ->required(),
                        TextInput::make('email')
                            ->columnSpan(['xl' => 3])
                            ->email()
                            ->required(),
                        TextInput::make('password')
                            ->columnSpan(['xl' => 3])
                            ->password()
                            ->confirmed()
                            ->required(),
                        TextInput::make('password_confirmation')
                            ->columnSpan(['xl' => 3])
                            ->password()
                            ->required()
                            ->maxLength(255)
                            ->same('password')
                            ->dehydrated(false)
                            ->label('Confirm Password'),
                        TextInput::make('phone')
                            ->columnSpan(['xl' => 3])
                            ->label('No Telp'),
                        Textarea::make('alamat')
                            ->columnSpan(['xl' => 3]),
                        Hidden::make('role')
                            ->default('juleha')
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_sertifikat')
                    ->label('Nomor Sertifikat'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Lengkap'),
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
            'index' => Pages\ListJulehas::route('/'),
            'create' => Pages\CreateJuleha::route('/create'),
            'edit' => Pages\EditJuleha::route('/{record}/edit'),
        ];
    }

    // canViewAny
    public static function canViewAny(): bool
    {
        return auth()->user()?->role == 'admin_rph';
    }

    /*
     * getEloquentQuery
     * @return Builder
     * */
    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        if (!$user->profile->rph_id) {
            return parent::getEloquentQuery()->whereRaw('1 = 0');
        }

        return Juleha::with('user')
            ->whereHas('rphs', function ($query) use ($user) {
                $query->where('rph_id', $user->profile->rph_id);
            });
    }
}
