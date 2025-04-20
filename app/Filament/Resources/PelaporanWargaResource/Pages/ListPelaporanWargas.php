<?php

namespace App\Filament\Resources\PelaporanWargaResource\Pages;

use App\Filament\Resources\PelaporanWargaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPelaporanWargas extends ListRecords
{
    protected static string $resource = PelaporanWargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
