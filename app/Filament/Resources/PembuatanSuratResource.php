<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembuatanSuratResource\Pages;
use App\Models\Pembuatan_Surat;
use App\Models\JenisSurat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Radio;
use Illuminate\Support\Str;
use Filament\Tables\Columns\TextColumn;
use PhpOffice\PhpWord\TemplateProcessor;
use Filament\Tables\Actions\Action;

class PembuatanSuratResource extends Resource
{
    public static function getNavigationLabel(): string
    {
        return 'SKTM';
    }

    protected static ?string $model = Pembuatan_Surat::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Surat')
                    ->schema([
                        Select::make('jenis_surat')
                            ->label('Jenis Surat')
                            ->options([
                                'sktm' => 'Surat Keterangan Tidak Mampu',
                                'skd' => 'Surat Keterangan Domisili',
                                'skp' => 'Surat Keterangan Pengantar',
                                'skk' => 'Surat Keterangan Kematian',
                            ])
                            ->required(),

                        TextInput::make('nomor_surat')
                            ->label('Nomor Surat')
                            ->placeholder('001/RW.001/V/2025')
                            ->required(),

                        DatePicker::make('tanggal_surat')
                            ->label('Tanggal Surat')
                            ->default(now())
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Data Pemohon')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('nik')
                            ->label('NIK')
                            ->required()
                            ->maxLength(16)
                            ->minLength(16)
                            ->numeric(),

                        DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->required(),

                        TextInput::make('tempat_lahir')
                            ->label('Tempat Lahir')
                            ->required()
                            ->maxLength(255),

                        Radio::make('jenis_kelamin')
                            ->label('Jenis Kelamin')
                            ->options([
                                'Laki-laki' => 'Laki-laki',
                                'Perempuan' => 'Perempuan',
                            ])
                            ->required(),

                        Select::make('agama')
                            ->label('Agama')
                            ->options([
                                'Islam' => 'Islam',
                                'Kristen' => 'Kristen',
                                'Katolik' => 'Katolik',
                                'Hindu' => 'Hindu',
                                'Buddha' => 'Buddha',
                                'Konghucu' => 'Konghucu',
                            ])
                            ->required(),

                        TextInput::make('pekerjaan')
                            ->label('Pekerjaan')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('alamat')
                            ->label('Alamat')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('rt')
                            ->label('RT')
                            ->required()
                            ->maxLength(3)
                            ->numeric(),

                        TextInput::make('rw')
                            ->label('RW')
                            ->required()
                            ->maxLength(3)
                            ->numeric(),

                        TextInput::make('kelurahan')
                            ->label('Kelurahan')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('kecamatan')
                            ->label('Kecamatan')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('kota')
                            ->label('Kota/Kabupaten')
                            ->required()
                            ->maxLength(255),
                    ])->columns(3),

                Forms\Components\Section::make('Keterangan Tambahan')
                    ->schema([
                        Textarea::make('keperluan')
                            ->label('Keperluan')
                            ->required()
                            ->rows(3),

                        TextInput::make('nama_ketua_rw')
                            ->label('Nama Ketua RW')
                            ->default('BAMBANG SUDARSONO')
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor_surat')
                    ->label('Nomor Surat')
                    ->searchable(),

                TextColumn::make('jenis_surat')
                    ->label('Jenis Surat')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'sktm' => 'Surat Keterangan Tidak Mampu',
                        'skd' => 'Surat Keterangan Domisili',
                        'skp' => 'Surat Keterangan Pengantar',
                        'skk' => 'Surat Keterangan Kematian',
                        default => $state,
                    })
                    ->searchable(),

                TextColumn::make('nama')
                    ->label('Nama Pemohon')
                    ->searchable(),

                TextColumn::make('tanggal_surat')
                    ->label('Tanggal Surat')
                    ->date('d F Y')
                    ->sortable(),

                TextColumn::make('keperluan')
                    ->label('Keperluan')
                    ->limit(50),
            ])
            ->filters([
                // Filter jika diperlukan
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('download')
                    ->label('Download Surat')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action(function (Pembuatan_Surat $record) {
                        return self::downloadSurat($record);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected static function downloadSurat(Pembuatan_Surat $record)
    {
        $templatePath = storage_path('app/templates/');
        $outputPath = storage_path('app/temp/');

        // Pilih template berdasarkan jenis surat
        $templateFile = match ($record->jenis_surat) {
            'sktm' => $templatePath . 'template_sktm.docx',
            'skd' => $templatePath . 'template_skd.docx',
            'skp' => $templatePath . 'template_skp.docx',
            'skk' => $templatePath . 'template_skk.docx',
            default => $templatePath . 'template_sktm.docx',
        };

        // Buat nama file yang unik
        $outputFileName = Str::slug($record->jenis_surat . '-' . $record->nama . '-' . now()->timestamp) . '.docx';
        $outputFilePath = $outputPath . $outputFileName;

        // Pastikan direktori ada
        if (!file_exists($outputPath)) {
            mkdir($outputPath, 0755, true);
        }

        // Load template dan isi data
        $templateProcessor = new TemplateProcessor($templateFile);

        // Data umum untuk semua jenis surat
        $templateProcessor->setValue('nomor_surat', $record->nomor_surat);
        $templateProcessor->setValue('nama', strtoupper($record->nama));
        $templateProcessor->setValue('nik', $record->nik);
        $templateProcessor->setValue('tempat_lahir', $record->tempat_lahir);
        $templateProcessor->setValue('tanggal_lahir', date('d-m-Y', strtotime($record->tanggal_lahir)));
        $templateProcessor->setValue('jenis_kelamin', $record->jenis_kelamin);
        $templateProcessor->setValue('agama', $record->agama);
        $templateProcessor->setValue('pekerjaan', $record->pekerjaan);
        $templateProcessor->setValue('alamat', $record->alamat);
        $templateProcessor->setValue('rt', $record->rt);
        $templateProcessor->setValue('rw', $record->rw);
        $templateProcessor->setValue('kelurahan', $record->kelurahan);
        $templateProcessor->setValue('kecamatan', $record->kecamatan);
        $templateProcessor->setValue('kota', $record->kota);
        $templateProcessor->setValue('keperluan', $record->keperluan);
        $templateProcessor->setValue('tanggal_surat', date('d F Y', strtotime($record->tanggal_surat)));
        $templateProcessor->setValue('nama_ketua_rw', strtoupper($record->nama_ketua_rw));

        // Simpan file
        $templateProcessor->saveAs($outputFilePath);

        // Download file
        return response()->download($outputFilePath)->deleteFileAfterSend(true);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPembuatanSurats::route('/'),
            'create' => Pages\CreatePembuatanSurat::route('/create'),
            'edit' => Pages\EditPembuatanSurat::route('/{record}/edit'),
        ];
    }
}
