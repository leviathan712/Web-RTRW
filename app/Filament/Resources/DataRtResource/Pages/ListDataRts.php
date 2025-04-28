<?php

namespace App\Filament\Resources\DataRtResource\Pages;

use App\Filament\Resources\DataRtResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder; // Tambahkan ini

class ListDataRts extends ListRecords
{
    protected static string $resource = DataRtResource::class;

    public function getTitle(): string
    {
        return 'Daftar Rukun Tetangga RW.009'; // Judul custom
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->orderBy('rt', 'asc'); // Urut berdasarkan nomor RT
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('rt')->label('RT'),
            TextColumn::make('nama_rt')->label('Nama RT'),
            TextColumn::make('alamat_rt')->label('Alamat RT'),
            TextColumn::make('periode_jabatan')->label('Periode Jabatan'),
            TextColumn::make('warga_count')->label('Jumlah Warga')->counts('warga'),
            TextColumn::make('created_at')->label('Dibuat Pada')->dateTime(),
        ];
    }

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
