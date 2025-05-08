<?php

namespace App\Filament\Resources\PembuatanSuratResource\Pages;

use App\Filament\Resources\PembuatanSuratResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPembuatanSurats extends ListRecords
{
    protected static string $resource = PembuatanSuratResource::class;

    public function getTitle(): string
    {
        return 'Layanan Pembuatan Surat RW.001';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
