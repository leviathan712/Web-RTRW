<?php

namespace App\Filament\Resources\PembuatanSuratResource\Pages;

use App\Filament\Resources\PembuatanSuratResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPembuatanSurat extends EditRecord
{
    protected static string $resource = PembuatanSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
