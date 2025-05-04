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
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_lahir' => 'date',
    ];
}
