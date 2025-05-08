<?php

namespace App\Filament\Widgets;

use App\Models\KegiatanWarga;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget\Card;

class KegiatanWargaDashboardWidget extends StatsOverviewWidget
{

    protected ?string $heading = 'Terjadwal Kegiatan Warga';
    public function getCards(): array
    {
        $direncanakanCount = KegiatanWarga::where('status_pelaksanaan', '1')->count();
        $selesaiCount = KegiatanWarga::where('status_pelaksanaan', '5')->count();

        return [
            Card::make('Kegiatan Direncanakan', $direncanakanCount)
                ->description('Jumlah kegiatan yang direncanakan')
                ->color('primary'),
            Card::make('Kegiatan Selesai', $selesaiCount)
                ->description('Jumlah kegiatan yang selesai')
                ->color('success'),
        ];
    }
}
