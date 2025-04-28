<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelaporan_Warga extends Model
{
    use HasFactory;
    protected $table = 'pelaporan_warga';

    protected $fillable = [
        'kategori',
        'rt',
        'deskripsi',
        'foto',
    ];
}
