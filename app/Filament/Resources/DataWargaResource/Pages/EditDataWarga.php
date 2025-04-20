<?php

namespace App\Filament\Resources\DataWargaResource\Pages;

use App\Filament\Resources\DataWargaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataWarga extends EditRecord
{
    protected static string $resource = DataWargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
