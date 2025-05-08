<?php

namespace App\Filament\Widgets;

use App\Models\TransaksiKeuangan;
use Filament\Widgets\TableWidget;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class KeuanganTableWidget extends TableWidget
{
    protected int|string|array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        $query = TransaksiKeuangan::query()->latest();

        if (auth()->user()->hasRole('rt')) {
            $query->where('rt', auth()->user()->rt)->where('tingkat', 'rt');
        }

        if (auth()->user()->hasRole('warga')) {
            $query->where(function ($q) {
                $q->where('tingkat', 'rw')
                  ->orWhere('rt', auth()->user()->rt);
            });
        }

        return $query;
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('judul')->label('Judul')->searchable(),
            TextColumn::make('tipe')->label('Tipe')->badge()
                ->color(fn ($state) => $state === 'pemasukan' ? 'success' : 'danger'),
            TextColumn::make('jumlah')->label('Jumlah')->money('IDR'),
            TextColumn::make('tingkat')->label('Tingkat'),
            TextColumn::make('rt')->label('RT'),
            TextColumn::make('created_at')->label('Tanggal')->date('d M Y'),
        ];
    }
}
