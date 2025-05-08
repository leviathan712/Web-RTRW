<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataWarga extends Model
{
    use HasFactory;

    // Tabel nya harus disebut manual
    protected $table = 'data_warga';

    protected $fillable = [
        'nik',
        'name',
        'tanggal_lahir',
        'email',
        'no_hp',
        'alamat',
        'rt',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     // Relasi ke DataWarga (1 RT memiliki banyak Warga)
     public function warga()
     {
         return $this->hasMany(DataWarga::class, 'rt_id');
     }
}
