<?php

namespace App\Filament\Resources\DataWargaResource\Pages;

use App\Filament\Resources\DataWargaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDataWargas extends ListRecords
{
    protected static string $resource = DataWargaResource::class;
    public function getTitle(): string
    {
        return 'Daftar Data Warga'; // Judul custom yang Anda inginkan
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
