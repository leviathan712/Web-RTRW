<?php

namespace App\Filament\Resources\KegiatanWargaResource\Pages;

use App\Filament\Resources\KegiatanWargaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKegiatanWargas extends ListRecords
{
    protected static string $resource = KegiatanWargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
