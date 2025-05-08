<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembuatan_Surat extends Model
{
    use HasFactory;

    protected $table = 'pembuatan_surats';

    protected $fillable = [
        'jenis_surat',
        'nomor_surat',
        'tanggal_surat',
        'nama',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'pekerjaan',
        'alamat',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'kota',
        'keperluan',
        'nama_ketua_rw',
        'status_verifikasi',
        'alasan_ditolak',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_lahir' => 'date',
    ];

    public static function boot()
{
    parent::boot();

    static::updated(function ($model) {
        // Misalnya ada kode yang mengubah status_verifikasi
        if ($model->is_verified) {
            $model->update(['status_verifikasi' => 'Menunggu']);
        }
    });
}
}
