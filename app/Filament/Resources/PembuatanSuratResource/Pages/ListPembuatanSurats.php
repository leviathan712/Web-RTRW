<?php

namespace App\Filament\Resources\PembuatanSuratResource\Pages;

use App\Filament\Resources\PembuatanSuratResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPembuatanSurats extends ListRecords
{
    protected static string $resource = PembuatanSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
