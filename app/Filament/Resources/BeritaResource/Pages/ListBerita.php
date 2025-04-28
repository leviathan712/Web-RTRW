<?php

namespace App\Filament\Resources\BeritaResource\Pages;

use App\Filament\Resources\BeritaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBerita extends ListRecords
{
    protected static string $resource = BeritaResource::class;

    public function getTitle(): string
    {
        return 'Kelola Berita'; // Judul custom yang Anda inginkan
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
