<?php

namespace App\Filament\Resources\DataRtResource\Pages;

use App\Filament\Resources\DataRtResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDataRt extends CreateRecord
{
    protected static string $resource = DataRtResource::class;
    public function getTitle(): string
    {
        return 'Buat Rukun Tetangga'; // Judul custom yang Anda inginkan
    }
}
