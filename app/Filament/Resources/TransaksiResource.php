<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Filament\Resources\TransaksiResource\RelationManagers;
use App\Models\Lapak;
use App\Models\Ternak;
use App\Models\Transaksi;
//use App\Models\Transaksi;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransaksiResource extends Resource
{
    protected static null|string $model = Transaksi::class;
    protected static null|string $navigationLabel = 'Transaksi';
    protected static null|string $breadcrumb = 'Transaksi';

    protected static null|string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $rphId = Filament::auth()->user()->profile?->rph_id;
        $lapak = Lapak::with('user')->get();
        return $form->schema([
            Forms\Components\Hidden::make('rph_id')->default($rphId),
            Select::make('iot_id')
                ->relationship('iot', 'node') // or a readable field like 'name'
                ->nullable()
                ->label('IoT'),
            Select::make('lapak_id')
                ->options($lapak->mapWithKeys(function ($lapak) {
                    return $lapak->user
                        ? [
                            $lapak->user->id => $lapak->user->name,
                        ] : null;
                }))
                ->nullable()
                ->label('Lapak'),
            Select::make('ternak_id')
                ->native(false)
                ->options(function () use ($rphId) {
                    return Ternak::whereNotNull('waktu_sembelih')
                        ->where('rph_id', $rphId)
                        ->where('sisa_karkas', '>', 0)
                        ->get()
                        ->mapWithKeys(function ($ternak) {
                            $date = Carbon::parse($ternak->waktu_daftar)->format('m/d');
                            $id = str_pad($ternak->no_antri, 3, '0', STR_PAD_LEFT);
                            return [$ternak->id => "{$date}-{$id}"];
                        });
                })
                ->nullable()
                ->live()
                ->label('Ternak'),
            TextInput::make('jumlah')
                ->numeric()
                ->maxValue(fn(Get $get) => Ternak::find($get('ternak_id'))->sisa_karkas ?? 0)
                ->required()
                ->label('Jumlah'),
            DateTimePicker::make('waktu_kirim')
                ->default(now())
                ->seconds(false)
                //->native(false)
                ->required()
                ->label('Waktu Kirim'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lapak.user.name')->label('Nama Lapak'),
                Tables\Columns\TextColumn::make('jumlah'),
                Tables\Columns\TextColumn::make('status_kirim'),
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
            ])->defaultSort('id', 'desc');
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
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->role == 'admin_rph';
    }
}
