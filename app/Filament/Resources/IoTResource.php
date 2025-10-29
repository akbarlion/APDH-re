<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IoTResource\Pages;
use App\Filament\Resources\IoTResource\RelationManagers;
use App\Models\IoT;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IoTResource extends Resource
{
    protected static null|string $model = IoT::class;

    protected static null|string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static null|int $navigationSort = 3;

    // Navigation label
    protected static null|string $navigationLabel = 'IoT';
    protected static null|string $breadcrumb = 'IoT';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('node'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // OLD CODE - empty columns causing empty rows
                // //
                // NEW CODE - add proper columns to display IoT data
                // Tables\Columns\TextColumn::make('id')
                //     ->label('ID')
                //     ->sortable(),
                Tables\Columns\TextColumn::make('node')
                    ->label('Node')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListIoTS::route('/'),
            'create' => Pages\CreateIoT::route('/create'),
            'edit' => Pages\EditIoT::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return in_array(auth()->user()?->role, ['super_admin', 'admin_rph']);
    }
}
