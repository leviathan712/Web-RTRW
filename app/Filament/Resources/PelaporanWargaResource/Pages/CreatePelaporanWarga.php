<?php
namespace App\Filament\Resources\PelaporanWargaResource\Pages;

use App\Filament\Resources\PelaporanWargaResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions\Action;

class CreatePelaporanWarga extends CreateRecord
{
    protected static string $resource = PelaporanWargaResource::class;

    public static function createAction(): Action
    {
        return Action::make('create')
            ->label('Buat Laporan Warga') // Ubah teks tombol di sini
            ->icon('heroicon-o-plus'); // Tambahkan ikon jika diinginkan
    }

    public function getTitle(): string
    {
        return 'Buat Laporan Warga'; // Judul custom yang Anda inginkan
    }
}
