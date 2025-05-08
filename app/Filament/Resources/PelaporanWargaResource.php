<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PelaporanWargaResource\Pages;
use App\Models\DataRt;
use App\Models\Pelaporan_Warga;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class PelaporanWargaResource extends Resource
{
    public static function getNavigationLabel(): string
    {
        return 'Pelaporan Warga';
    }

    protected static ?string $navigationGroup = 'Pelaporan Warga Online';

    protected static ?string $model = Pelaporan_Warga::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    
    public static function createAction(): Action
    {
        return Action::make('create')
            ->label('Buat Laporan Warga') // Ganti teks tombol di sini
            ->icon('heroicon-o-plus'); // Menambahkan ikon jika diinginkan
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('kategori')
                    ->label('Kategori Laporan')
                    ->options([
                        'keamanan' => 'Keamanan',
                        'kebersihan' => 'Kebersihan',
                        'infrastruktur' => 'Infrastruktur',
                    ])
                    ->required()
                    ->searchable(),

                Forms\Components\Select::make('rt')
                    ->label('RT Pelapor')
                    ->options(fn () => DataRt::pluck('rt', 'rt')->toArray())
                    ->required()
                    ->searchable(),

                Forms\Components\Textarea::make('deskripsi')
                    ->label('Deskripsi Laporan')
                    ->required(),

                Forms\Components\FileUpload::make('foto')
                    ->label('Foto Pendukung')
                    ->image()
                    ->maxSize(10240) // 10 MB
                    ->directory('pelaporan-foto') // storage/app/public/pelaporan-foto
                    ->disk('public')
                    ->preserveFilenames()
                    ->live()
                    ->imagePreviewHeight('150')
                    ->visibility('public')
                    ->nullable()
                    ->deleteUploadedFileUsing(function ($record) {
                        if ($record && $record->foto) {
                            Storage::disk('public')->delete($record->foto);
                        }
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kategori')->label('Kategori'),
                Tables\Columns\TextColumn::make('rt')->label('RT'),
                Tables\Columns\TextColumn::make('deskripsi')->label('Deskripsi')->limit(50),
                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto')
                    ->height(50)
                    ->getStateUsing(fn ($record) => $record->foto ? asset('storage/pelaporan-foto/' . basename($record->foto)) : null)
                    ->circular()
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('created_at')->label('Dilaporkan Pada')->dateTime('d M Y H:i'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('rt')
                    ->label('Filter berdasarkan RT')
                    ->options(fn () => DataRt::pluck('rt', 'rt')->toArray()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    protected static function modifyQueryUsing(Builder $query): Builder
    {
        if (auth()->user()->hasRole('RT')) {
            return $query->where('rt', auth()->user()->rt);
        }

        return $query;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPelaporanWarga::route('/'),
            'create' => Pages\CreatePelaporanWarga::route('/create'),
            'edit' => Pages\EditPelaporanWarga::route('/{record}/edit'),
        ];
    }
}
