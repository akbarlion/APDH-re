<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LapakResource\Pages;
use App\Filament\Resources\LapakResource\RelationManagers;
use App\Models\Lapak;
use App\Models\Pasar;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LapakResource extends Resource
{
    protected static null|string $model = User::class;
    protected static null|string $navigationLabel = 'Lapak';
    protected static null|string $breadcrumb = 'Lapak';

    protected static null|string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->columnSpan(['xl' => 3])
                ->label('Nama Lapak')
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
            Forms\Components\TextInput::make('phone')->columnSpan(['xl' => 3])->label('No Telp'),
            Forms\Components\Textarea::make('alamat')->columnSpan(['xl' => 3]),
            Forms\Components\Hidden::make('role')->default('lapak'),
            Forms\Components\Fieldset::make('Keterangan')
                ->relationship('profile')
                ->schema([
                    Forms\Components\TextInput::make('no_lapak'),
                    Forms\Components\Select::make('pasar_id')
                        ->native(false)
                        ->options(Pasar::all()->pluck('name', 'id'))
                        ->required(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_lapak')->searchable(),
                Tables\Columns\TextColumn::make('pasar.name')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('telp')->searchable(),
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
            'index' => Pages\ListLapaks::route('/'),
            'create' => Pages\CreateLapak::route('/create'),
            'edit' => Pages\EditLapak::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        /*
         * if (!$user ||!$user->profile ||!$user->profile->rph_id) {
         * return parent::getEloquentQuery()->whereRaw('1 = 0');
         * }
         *
         * $userIds = Peternak::where('rph_id', $user->profile?->rph_id)
         * ->pluck('user_id');
         *
         * return User::whereIn('id', $userIds);
         */
        if (request()->routeIs('filament.admin.resources.lapaks.edit')) {
            return parent::getEloquentQuery();
        }

        return Lapak::query();
    }
}
