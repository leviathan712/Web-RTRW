<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PelaporanWargaResource\Pages;
use App\Filament\Resources\PelaporanWargaResource\RelationManagers;
use App\Models\Pelaporan_Warga;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PelaporanWargaResource extends Resource
{
    public static function getNavigationLabel(): string
    {
        return 'Pelaporan Warga';
    }

    protected static ?string $model = Pelaporan_Warga::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
            'index' => Pages\ListPelaporanWargas::route('/'),
            'create' => Pages\CreatePelaporanWarga::route('/create'),
            'edit' => Pages\EditPelaporanWarga::route('/{record}/edit'),
        ];
    }
}
