<?php
/*
 *
 * TODO:
 * - Dude make your table migrations first looooool filament won't do that for you
 *
 * */

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columns(['xl' => 6])
                    ->schema([
                        Forms\Components\TextInput::make('fullname')
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
                         Forms\Components\Select::make('role')
                             ->columnSpan(['xl' => 3])
                             ->options([
                                 'super_admin' => 'Super Admin',
                                 'admin_rph' => 'Admin RPH',
                                 'penyelia' => 'Penyelia',
                                 'juleha' => 'Juleha',
                                 'peternak' => 'Peternak',
                                 'lapak' => 'Lapak'
                             ])
                             ->native(false)
                             ->required()
                             ->live(),
                    ]),

                    Forms\Components\Fieldset::make('Role')
                        ->schema([])
                        ->visible(fn (
                            Forms\Get $get
                        ) => $get('role') == ''),

                    Forms\Components\Fieldset::make('Juleha')
                        ->schema([
                         Forms\Components\TextInput::make('nomor_sertifikat')
                             ->columnSpan(['xl' => 3])
                             ->label('Nomor Sertifikat'),
                         Forms\Components\TextInput::make('masa_sertifikat')
                             ->columnSpan(['xl' => 3])
                             ->label('Masa Berlaku'),
                         Forms\Components\TextInput::make('upload_sertifikat')
                             ->columnSpan(['xl' => 3])
                             ->label('Upload Sertifikat'),
                        ])
                        ->visible(fn (
                            Forms\Get $get
                        ) => $get('role') === 'juleha'),

                    Forms\Components\Fieldset::make('Penyelia')
                        ->columns(['xl' => 6])
                        ->relationship('profile')
                        ->schema([
                         Forms\Components\TextInput::make('nip')
                             ->columnSpan(['xl' => 3])
                             ->label('Nomor Induk Penyelia'),
                         Forms\Components\TextInput::make('rph')
                             ->columnSpan(['xl' => 3])
                             ->label('RPH'),
                         Forms\Components\TextInput::make('status')
                             ->columnSpan(['xl' => 3]),
                         Forms\Components\DatePicker::make('tgl_berlaku')
                             ->columnSpan(['xl' => 3])
                             ->native(false)
                             ->label('Tanggal Berlaku'),
                         Forms\Components\FileUpload::make('file_sk')
                             ->columnSpan(['xl' => 3])
                             ->label('Upload SK'),
                        ])
                        ->visible(fn (
                            Forms\Get $get
                        ) => $get('role') === 'penyelia'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
