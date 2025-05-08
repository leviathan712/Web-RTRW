<?php
namespace App\Filament\Resources\PelaporanWargaResource\Pages;

use App\Filament\Resources\PelaporanWargaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPelaporanWarga extends ListRecords
{
    protected static string $resource = PelaporanWargaResource::class;

    public function getTitle(): string
    {
        return 'Lapor Warga Online'; // Judul custom yang Anda inginkan
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Laporan Warga') // Ubah label tombol di sini
                ->icon('heroicon-o-plus'), // Tambahkan ikon jika diinginkan
        ];
    }
}
