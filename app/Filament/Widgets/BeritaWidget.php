<?php

namespace App\Filament\Widgets;

use App\Models\Berita;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Carbon\Carbon;

class BeritaWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Berita Terbaru';

    protected function getCards(): array
    {
        // Mengambil berita terbaru
        $beritas = Berita::orderBy('tanggal', 'desc')->limit(5)->get();

        // Membuat card untuk setiap berita
        $cards = $beritas->map(function ($berita) {
            $judul = $berita->judul_berita ?? 'Judul Tidak Tersedia';  // Menangani jika judulnya null
            $konten = \Str::limit($berita->isi_berita?? 'Konten Tidak Tersedia', 100);  // Menangani jika konten null
            $tanggal = $berita->tanggal ? Carbon::parse($berita->tanggal)->format('d M Y') : 'Tanggal Tidak Tersedia'; 
            return Card::make($judul, $konten)
                ->description($tanggal)
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('primary');
                // ->url(route('berita.show', $berita));
        });

        return $cards->toArray(); // Mengembalikan array card
    }
}
