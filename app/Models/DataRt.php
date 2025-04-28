<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataRt extends Model
{
    use HasFactory;

    protected $fillable = ['nik','rt', 'nama_rt', 'alamat_rt', 'periode_jabatan'];

    // Relasi ke DataWarga (1 RT memiliki banyak Warga)
    public function warga()
    {
        return $this->hasMany(DataWarga::class, 'rt_id');
    }
}
