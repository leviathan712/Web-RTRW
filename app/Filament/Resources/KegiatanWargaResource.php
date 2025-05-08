<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KegiatanWargaResource\Pages;
use App\Models\KegiatanWarga;
use App\Models\DataWarga;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Log;
use Filament\Widgets\StatsOverviewWidget;
use Illuminate\Support\Facades\Redirect;

class KegiatanWargaResource extends Resource
{
    protected static ?string $model = KegiatanWarga::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Buat Pengumuman';

    public static function getNavigationLabel(): string
    {
        return 'Kegiatan Warga';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_kegiatan')
                    ->required(),

                Forms\Components\TextInput::make('deskripsi')
                    ->required(),

                Forms\Components\DatePicker::make('tanggal_pelaksanaan')
                    ->required(),

                Forms\Components\Select::make('status_pelaksanaan')
                    ->options([
                        '1' => 'Direncanakan',
                        '5' => 'Selesai',
                    ])
                    ->required(),

                    Forms\Components\Select::make('rt')
                    ->label('RT')
                    ->options([
                        '001' => 'RT 001',
                        '002' => 'RT 002',
                        '003' => 'RT 003',
                        '004' => 'RT 004',
                        '005' => 'RT 005',
                        '006' => 'RT 006',
                        '007' => 'RT 007',
                        '008' => 'RT 008',
                        '009' => 'RT 009',
                        '010' => 'RT 010',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_kegiatan'),
                Tables\Columns\TextColumn::make('deskripsi'),
                Tables\Columns\TextColumn::make('tanggal_pelaksanaan'),
                Tables\Columns\TextColumn::make('status_pelaksanaan')
                    ->label('Status')
                    ->getStateUsing(function ($record) {
                        // Tampilkan teks yang ramah pengguna sesuai dengan nilai di database
                        return $record->status_pelaksanaan == '1' ? 'Direncanakan' : 
                               ($record->status_pelaksanaan == '5' ? 'Selesai' : 'Status Tidak Dikenal');
                    }),
                Tables\Columns\TextColumn::make('rt')->label('RT'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_pelaksanaan')
                    ->options([
                        '1' => 'Direncanakan',
                        '5' => 'Selesai',
                    ])
                    ->label('Status Pelaksanaan'),
            ])
            ->actions([
                Tables\Actions\Action::make('Kirim Ke Warga')
                    ->label('Kirim ke RT')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $wargas = DataWarga::where('rt', $record->rt)->get();
                        foreach ($wargas as $warga) {
                            // Simulasi pengiriman (misal log atau notifikasi)
                            Log::info("Mengirim kegiatan '{$record->nama_kegiatan}' ke warga: {$warga->nama} (RT {$warga->rt})");
                        }
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getWidgets(): array
{
    return [
        \App\Filament\Widgets\KegiatanWargaDashboardWidget::class,
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
