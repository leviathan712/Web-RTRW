<?php

namespace App\Filament\Resources\PelaporanWargaResource\Pages;

use App\Filament\Resources\PelaporanWargaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPelaporanWarga extends EditRecord
{
    protected static string $resource = PelaporanWargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
