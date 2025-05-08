<?php

namespace App\Filament\Resources\DataWargaResource\Pages;

use App\Filament\Resources\DataWargaResource;
use App\Filament\Widgets\DataWargaStats;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Filters\SelectFilter;

class ListDataWargas extends ListRecords
{
    protected static string $resource = DataWargaResource::class;

    public function getTitle(): string
    {
        return 'Daftar Data Warga RW.001';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Data Warga')
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            DataWargaStats::class,
        ];
    }

    }
