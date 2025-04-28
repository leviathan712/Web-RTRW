<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembuatanSuratResource\Pages;
use App\Filament\Resources\PembuatanSuratResource\RelationManagers;
use App\Models\Pembuatan_Surat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PembuatanSuratResource extends Resource
{
    public static function getNavigationLabel(): string
    {
        return 'SKTM';
    }

    protected static ?string $model = Pembuatan_Surat::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

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
            'index' => Pages\ListPembuatanSurats::route('/'),
            'create' => Pages\CreatePembuatanSurat::route('/create'),
            'edit' => Pages\EditPembuatanSurat::route('/{record}/edit'),
        ];
    }
}
