<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KegiatanWargaResource\Pages;
use App\Filament\Resources\KegiatanWargaResource\RelationManagers;
use App\Models\Kegiatan_Warga;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KegiatanWargaResource extends Resource
{
    public static function getNavigationLabel(): string
    {
        return 'Kegiatan Warga';
    }

    protected static ?string $model = Kegiatan_Warga::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

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
            'index' => Pages\ListKegiatanWargas::route('/'),
            'create' => Pages\CreateKegiatanWarga::route('/create'),
            'edit' => Pages\EditKegiatanWarga::route('/{record}/edit'),
        ];
    }
}
