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
use App\Models\Rph;

use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;

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
                Section::make()
                    ->columns(['xl' => 6])
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
                         Select::make('role')
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

                    Fieldset::make('Role')
                        ->schema([])
                        ->visible(fn (
                            Forms\Get $get
                        ) => $get('role') == ''),

                    Fieldset::make('Super Admin')
                        ->schema([
                            Textarea::make('notes')
                            ->label('Catatan')
                        ])
                        ->visible(fn (
                            Forms\Get $get
                        ) => $get('role') == 'super_admin'),

                    Fieldset::make('Admin RPH')
                        ->relationship('profile')
                        ->schema([
                            Select::make('rph_id')
                                ->label('RPH')
                                ->native(false)
                                ->options(Rph::all()->pluck('name', 'id'))
                                ->default(function ($record) {
                                    if ($record && $record->profile && $record->profile->rph_id) {
                                        return $record->profile->rph_id;
                                    }
                                    return null; // No default if no linked RPH
                                })
                                ->disabled(function ($get, $state) {
                                    return RPH::count() === 0;
                                })
                                ->hint(function ($state) {
                                    if (RPH::count() === 0) {
                                        return 'Please add an RPH first.';
                                    }
                                    return null;
                                })
                        ])
                        ->visible(fn (
                            Forms\Get $get
                        ) => $get('role') == 'admin_rph'),

                    Fieldset::make('Juleha')
                        ->relationship('profile')
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
                        ])
                        ->visible(fn (
                            Forms\Get $get
                        ) => $get('role') === 'juleha'),

                    Fieldset::make('Penyelia')
                        ->columns(['xl' => 6])
                        ->relationship('profile')
                        ->schema([
                         TextInput::make('nip')
                             ->columnSpan(['xl' => 3])
                             ->label('Nomor Induk Penyelia'),
                         TextInput::make('rph')
                             ->columnSpan(['xl' => 3])
                             ->label('RPH'),
                         TextInput::make('status')
                             ->columnSpan(['xl' => 3]),
                         DatePicker::make('tgl_berlaku')
                             ->columnSpan(['xl' => 3])
                             ->native(false)
                             ->label('Tanggal Berlaku'),
                         FileUpload::make('file_sk')
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
