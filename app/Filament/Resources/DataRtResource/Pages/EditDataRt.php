<?php

namespace App\Filament\Resources\DataRtResource\Pages;

use App\Filament\Resources\DataRtResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataRt extends EditRecord
{
    protected static string $resource = DataRtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
