<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Berita;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Facades\Http;
use App\Filament\Resources\BeritaResource\Pages;

class BeritaResource extends Resource
{
    protected static ?string $model = Berita::class;
    protected static ?string $navigationGroup = 'Buat Pengumuman';
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function getNavigationLabel(): string
    {
        return 'Berita';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('judul_berita')->label('Judul Berita')->required(),
                DatePicker::make('tanggal')->required(),
                Textarea::make('isi_berita')->label('Isi Berita')->rows(10)->required(),
                TextInput::make('tempat_kejadian')->label('Tempat Kejadian'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul_berita'),
                Tables\Columns\TextColumn::make('isi_berita')->limit(100)->wrap(),
                Tables\Columns\TextColumn::make('tanggal'),
                Tables\Columns\TextColumn::make('tempat_kejadian'),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBerita::route('/'),
            'create' => Pages\CreateBerita::route('/create'),
            'edit' => Pages\EditBerita::route('/{record}/edit'),
        ];
    }
}
