<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Pembuatan_Surat;

class SuratStatsOverviewWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Pengajuan Pelayanan Surat';
    protected function getCards(): array
    {
        $menunggu = Pembuatan_Surat::where('status_verifikasi', 'Menunggu')->count();
        $terverifikasi = Pembuatan_Surat::where('status_verifikasi', 'Disetujui')->count();
        $ditolak = Pembuatan_Surat::where('status_verifikasi', 'Ditolak')->count();

        return [
            Card::make('Menunggu Verifikasi', $menunggu)
                ->description('Surat belum diproses')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Card::make('Terverifikasi', $terverifikasi)
                ->description('Sudah disetujui oleh RW/RT')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Card::make('Ditolak', $ditolak)
                ->description('Pengajuan ditolak')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
