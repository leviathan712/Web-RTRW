<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataWargaResource\Pages;
use App\Models\DataWarga;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class DataWargaResource extends Resource
{
    protected static ?string $model = DataWarga::class;

    protected static ?string $navigationGroup = 'Data Lingkungan RW';
    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static function getNavigationLabel(): string
    {
        return 'Data Warga';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nik')
                ->label('NIK')
                ->numeric()
                ->minLength(16)
                ->maxLength(16)
                ->required(),

            Forms\Components\TextInput::make('name')
                ->label('Nama Lengkap')
                ->required(),

            Forms\Components\DatePicker::make('tanggal_lahir')
                ->label('Tanggal Lahir')
                ->required(),
            
            Forms\Components\TextInput::make('email')
                ->label('Email')
                ->email()
                ->nullable(),

            Forms\Components\TextInput::make('no_hp')
                ->label('Nomor HP')
                ->nullable(),

            Forms\Components\Textarea::make('alamat')
                ->label('Alamat')
                ->nullable(),

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
            
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
        Tables\Columns\TextColumn::make('rt')
                ->label('RT')
                ->sortable(),
                
        Tables\Columns\TextColumn::make('nik')
            ->label('NIK')
            ->searchable()
            ->sortable(),
    
        Tables\Columns\TextColumn::make('name')
            ->label('Nama')
            ->searchable()
            ->sortable(),
        
        Tables\Columns\TextColumn::make('tanggal_lahir')
            ->label('Tanggal Lahir')
            ->date()
            ->sortable(),
    
        Tables\Columns\TextColumn::make('email')
            ->label('Email')
            ->searchable()
            ->sortable(),
    
        Tables\Columns\TextColumn::make('no_hp')
            ->label('No HP')
            ->searchable(),
    
        Tables\Columns\TextColumn::make('alamat')
            ->label('Alamat'),
    
    ])
    ->filters([
        SelectFilter::make('rt')
            ->label('Filter RT')
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
    ])
    ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
    ])
    ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
            Tables\Actions\DeleteBulkAction::make(),
        ]),
    ]);
}


    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDataWargas::route('/'),
            'create' => Pages\CreateDataWarga::route('/create'),
            'edit' => Pages\EditDataWarga::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        // Filter by RT if the user role is 'rt'
        if ($user->role === 'rt') {
            return $query->where('rt', $user->rt);
        }

        // Filter by user_id if the role is 'warga'
        if ($user->role === 'warga') {
            return $query->where('user_id', $user->id);
        }

        return $query;
    }
}
