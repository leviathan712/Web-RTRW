<?php

namespace App\Filament\Resources\PelaporanWargaResource\Pages;

use App\Filament\Resources\PelaporanWargaResource;
use Filament\Resources\Pages\EditRecord;

class EditPelaporanWarga extends EditRecord
{
    public function getTitle(): string
    {
        return 'Edit Lapor Warga'; // Judul custom yang Anda inginkan
    }

    protected static string $resource = PelaporanWargaResource::class;
}
