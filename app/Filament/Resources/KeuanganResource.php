<?php

namespace App\Filament\Resources;

use App\Exports\TransaksiKeuanganExport;
use App\Filament\Resources\KeuanganResource\Pages;
use App\Models\TransaksiKeuangan;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Tables\Actions\Action;

class KeuanganResource extends Resource
{
    protected static ?string $model = TransaksiKeuangan::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Keuangan RW';

    protected static ?string $navigationGroup = 'Keuangan';

    public static function form(Forms\Form $form): Forms\Form
    
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('tipe')
                    ->required()
                    ->options([
                        'pemasukan' => 'Pemasukan',
                        'pengeluaran' => 'Pengeluaran',
                    ]),

                Forms\Components\TextInput::make('jumlah')
                    ->numeric()
                    ->required(),

                Forms\Components\Textarea::make('keterangan'),

                Forms\Components\Select::make('tingkat')
                    ->required()
                    ->options([
                        'RW' => 'RW',
                        'RT' => 'RT',
                    ])
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('rt', null)),

                Forms\Components\Select::make('rt')
                    ->label('RT')
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
                    ->visible(fn (callable $get) => $get('tingkat') === 'RT'),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')->searchable(),
                Tables\Columns\BadgeColumn::make('tipe')->colors([
                    'success' => 'pemasukan',
                    'danger' => 'pengeluaran',
                ]),
                Tables\Columns\TextColumn::make('jumlah')->money('IDR'),
                Tables\Columns\TextColumn::make('tingkat'),
                Tables\Columns\TextColumn::make('rt')->label('RT')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat Pada')->dateTime('d M Y'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tingkat')->options([
                    'RW' => 'RW',
                    'RT' => 'RT',
                ]),
                Tables\Filters\SelectFilter::make('rt')->options([
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
                ])->visible(fn () => auth()->user()->hasRole(['admin', 'rw'])),
            ])
            ->headerActions([
                Action::make('export_excel')
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function () {
                        $rt = request('tableFilters')['rt']['value'] ?? null;
                        return Excel::download(new TransaksiKeuanganExport($rt), 'keuangan.xlsx');
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make()->visible(fn () => auth()->user()->hasRole(['admin', 'rw', 'rt'])),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->visible(fn () => auth()->user()->hasRole(['admin'])),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKeuangans::route('/'),
            'create' => Pages\CreateKeuangan::route('/create'),
            'edit' => Pages\EditKeuangan::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->user()->hasRole('rt')) {
            return $query->where('rt', auth()->user()->rt)->where('tingkat', 'rt');
        }

        if (auth()->user()->hasRole('warga')) {
            return $query->where(function ($q) {
                $q->where('tingkat', 'rw')
                  ->orWhere('rt', auth()->user()->rt);
            });
        }

        return $query;
    }
}
