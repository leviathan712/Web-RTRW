<?php

namespace App\Filament\Widgets;

use App\Models\DataWarga;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Forms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class DataWargaStats extends StatsOverviewWidget implements HasForms
{
    use InteractsWithForms;

    public ?string $rt = null;

    protected static bool $isLazy = false; // Penting biar langsung kebaca

    protected ?string $heading = 'Data Rentang Usia Di RW.001';

    protected function hasForm(): bool
    {
        return true;
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('rt')
                ->label('Pilih RT')
                ->options([
                    '001' => 'RT 001',
                    '002' => 'RT 002',
                    '003' => 'RT 003',
                    '004' => 'RT 004',
                    '005' => 'RT 005',
                    '006' => 'RT 006',
                    '007' => 'RT 007',
                    '008' => 'RT 008',
                    '009' => 'RT 009',
                    '010' => 'RT 010',
                ])
                ->reactive()
                ->afterStateUpdated(fn () => $this->dispatch('updateStats')),
        ];
    }

    protected function getStats(): array
    {
        $now = now();
        $query = DataWarga::query();
    
        // Ambil filter RT dari query string yang dipakai tabel
        $rt = request()->get('tableFilters')['rt']['value'] ?? null;
    
        if ($rt) {
            $query->where('rt', $rt);
        }
    
        return [
            Stat::make('Lansia', $query->clone()->whereDate('tanggal_lahir', '<=', $now->copy()->subYears(60))->count()),
            Stat::make('Dewasa', $query->clone()->whereBetween('tanggal_lahir', [
                $now->copy()->subYears(59),
                $now->copy()->subYears(18),
            ])->count()),
            Stat::make('Anak', $query->clone()->whereDate('tanggal_lahir', '>', $now->copy()->subYears(18))->count()),
        ];
    }
    
}
