<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataRtResource\Pages;
use App\Models\DataRt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DataRtResource extends Resource
{
    protected static ?string $model = DataRt::class;

    public static function getNavigationLabel(): string
    {
        return 'Data RT';
    }

    protected static ?string $navigationGroup = 'Data Lingkungan RW';
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nik')
                ->label('NIK')
                ->required()
                ->maxLength(16)
                ->unique(ignoreRecord: true),

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
                ->required(),

            Forms\Components\TextInput::make('nama_rt')
                ->label('Nama RT')
                ->required(),

            Forms\Components\TextInput::make('alamat_rt')
                ->label('Alamat RT')
                ->required(),

            Forms\Components\TextInput::make('periode_jabatan')
                ->label('Periode Jabatan')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nik')->label('NIK'),
                Tables\Columns\TextColumn::make('rt')->label('RT'),
                Tables\Columns\TextColumn::make('nama_rt')->label('Nama RT'),
                Tables\Columns\TextColumn::make('alamat_rt')->label('Alamat RT'),
                Tables\Columns\TextColumn::make('periode_jabatan')->label('Periode Jabatan'),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat Pada')->dateTime(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDataRts::route('/'),
            'create' => Pages\CreateDataRt::route('/create'),
            'edit' => Pages\EditDataRt::route('/{record}/edit'),
        ];
    }
}
