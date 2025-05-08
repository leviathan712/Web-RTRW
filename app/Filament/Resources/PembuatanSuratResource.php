<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembuatanSuratResource\Pages;
use App\Models\Pembuatan_Surat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Radio;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use PhpOffice\PhpWord\TemplateProcessor;
use Filament\Tables\Actions\Action;
use Illuminate\Notifications\Notification as NotificationsNotification;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PembuatanSuratResource extends Resource
{
    public static function getNavigationLabel(): string
    {
        return 'Pembuatan Surat';
    }

    protected static ?string $model = Pembuatan_Surat::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    public static function form(Form $form): Form
    {
        return $form
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
                    ->required()
                    ->default(function () {
                        $lastSurat = Pembuatan_Surat::latest('created_at')->first();
                        $nextNumber = 1;

                        if ($lastSurat) {
                            $lastNumber = substr($lastSurat->nomor_surat, 0, strpos($lastSurat->nomor_surat, '/'));
                            $nextNumber = (int) $lastNumber + 1;
                        }

                        return str_pad($nextNumber, 3, '0', STR_PAD_LEFT) . '/RW.001/V/2025';
                    }),

                DatePicker::make('tanggal_surat')
                    ->label('Tanggal Surat')
                    ->default(now())
                    ->required(),

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
                    ])
                    ->columns(3),

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
                    ])
                    ->columns(2),
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

                TextColumn::make('status_verifikasi')
                    ->label('Status')
                    ->formatStateUsing(function ($state) {
                        // Menampilkan label sesuai dengan status verifikasi
                        return match ($state) {
                            'Menunggu' => 'Menunggu Verifikasi',
                            'Disetujui' => 'Terverifikasi',
                            'Ditolak' => 'Ditolak',
                            default => 'Menunggu Verifikasi',
                        };
                    })
                    ->badge()
                    ->color(function ($state) {
                        // Menentukan warna berdasarkan status
                        return match ($state) {
                            'Menunggu' => 'warning',
                            'Disetujui' => 'success',
                            'Ditolak' => 'danger',
                            default => 'warning',
                        };
                    }),
                TextColumn::make('alasan_ditolak')
                    ->label('Alasan Ditolak')
                    ->limit(30) // optional biar ga kepanjangan
                    ->tooltip(fn ($record) => $record->alasan_ditolak),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                
                Action::make('download')
                    ->label('Download Surat')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn (Pembuatan_Surat $record) => route('surat.download', $record))
                    ->openUrlInNewTab()
                    ->visible(fn (Pembuatan_Surat $record) => $record->status_verifikasi === 'Disetujui')
                    ->action(function (Pembuatan_Surat $record) {
                        return self::downloadSurat($record);
                    }),
            
                    Action::make('verifikasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->label('Verifikasi')
                    ->action(function ($record) {
                        $record->update(['status_verifikasi' => 'Disetujui']);  // Update status menjadi Disetujui
        
                    Notification::make()
                    ->title('Verifikasi Berhasil')
                    ->success()
                    ->send();

                    return redirect()->route('filament.admin.resources.pembuatan-surats.index');

                }),

                Action::make('tolak')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->label('Tolak')
                ->visible(fn ($record) => $record->status_verifikasi === 'Menunggu')
                ->form([
                    Textarea::make('alasan_ditolak')
                        ->label('Alasan Penolakan')
                        ->required(),
                ])
                ->action(function (Pembuatan_Surat $record, array $data) {
                    $record->update([
                        'status_verifikasi' => 'Ditolak',
                        'alasan_ditolak' => $data['alasan_ditolak'],
                    ]);

                    Notification::make()
                        ->title('Permohonan Ditolak')
                        ->body('Alasan: ' . $data['alasan_ditolak'])
                        ->danger()
                        ->send();

                    return redirect()->route('filament.admin.resources.pembuatan-surats.index');
                }),

            ])
            ->bulkActions([
                    Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected static function downloadSurat(Pembuatan_Surat $record): BinaryFileResponse
{
    $templatePath = storage_path('app/templates/');
    $outputPath = storage_path('app/temp/');
    $record->refresh();

    // Pilih template berdasarkan jenis surat
    $templateFile = match ($record->jenis_surat) {
        'sktm' => $templatePath . 'template_sktm.docx',
        'skd' => $templatePath . 'template_skd.docx',
        'skp' => $templatePath . 'template_skp.docx',
        'skk' => $templatePath . 'template_skk.docx',
        default => $templatePath . 'template_sktm.docx',
    };

    // Nama file output
    $outputFileName = Str::slug($record->jenis_surat . '-' . $record->nama . '-' . now()->timestamp) . '.docx';
    $outputFilePath = $outputPath . $outputFileName;

    // Buat folder output jika belum ada
    if (!file_exists($outputPath)) {
        mkdir($outputPath, 0755, true);
    }

    $templateProcessor = new TemplateProcessor($templateFile);

    // Isi data umum
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

    // Tambahkan tanda tangan RW jika sudah diverifikasi
    if ($record->status_verifikasi === 'Disetujui') {
        $signaturePath = storage_path('app/signatures/ttd_rw.png');
        if (file_exists($signaturePath)) {
            $templateProcessor->setImageValue('ttd_rw', [
                'path' => $signaturePath,
                'width' => 100,
                'height' => 50,
                'ratio' => true,
            ]);
        } else {
            // Jika file ttd tidak ada, kosongkan
            $templateProcessor->setValue('ttd_rw', '');
        }
    } else {
        // Jika belum diverifikasi, kosongkan tanda tangan
        $templateProcessor->setValue('ttd_rw', '');
    }

    // Simpan dokumen hasil
    $templateProcessor->saveAs($outputFilePath);

    // Kirim ke user dan hapus setelah dikirim
    return response()->download($outputFilePath)->deleteFileAfterSend(true);
}


    public static function getRelations(): array
    {
        return [];
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
