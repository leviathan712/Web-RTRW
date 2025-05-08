<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanWarga extends Model
{
    // Menambahkan properti $fillable untuk mengizinkan mass assignment
    protected $fillable = [
        'nama_kegiatan',
        'deskripsi',
        'tanggal_pelaksanaan',
        'status_pelaksanaan',
        'rt', // Pastikan 'rt' sudah ditambahkan ke dalam fillable
    ];

    

    // Relasi ke DataWarga berdasarkan kolom rt
    public function warga()
    {
        return $this->hasMany(\App\Models\DataWarga::class, 'rt', 'rt');
    }
}
