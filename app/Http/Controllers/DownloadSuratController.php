<?php

namespace App\Http\Controllers;

use App\Models\Pembuatan_Surat;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadSuratController extends Controller
{
    public function downloadSurat(Pembuatan_Surat $record): BinaryFileResponse
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
}
