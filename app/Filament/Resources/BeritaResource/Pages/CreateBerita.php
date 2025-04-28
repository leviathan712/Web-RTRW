<?php

namespace App\Filament\Resources\BeritaResource\Pages;

use App\Models\Berita;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Http;
use App\Filament\Resources\BeritaResource;

class CreateBerita extends CreateRecord
{
    protected static string $resource = BeritaResource::class;

    protected function afterCreate(): void
    {
        $record = $this->record;

        $message = "📢 *Berita Baru!*\n"
            . "*Judul:* {$record->judul_berita}\n"
            . "*Tanggal:* {$record->tanggal}\n"
            . "*Tempat:* {$record->tempat_kejadian}\n"
            . "*Isi:* {$record->isi_berita}";

        if (app()->environment('local')) {
            \Log::info("Simulasi kirim pesan:\n" . $message);
        } else {
            Http::withHeaders([
                'Authorization' => 'Bearer c8a3b64aab2e4c40bfc91c7b',  // Ganti dengan token yang benar
                'Content-Type' => 'application/json',
            ])->post('https://kirim.pesan.biz/api/v2/send-message', [
                'phone' => '6287763276122',  // Ganti dengan nomor tujuan yang benar
                'message' => $message,
            ]);
        }
    }
}
