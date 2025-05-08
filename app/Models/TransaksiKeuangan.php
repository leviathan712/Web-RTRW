<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiKeuangan extends Model
{
    use HasFactory;

    protected $table = 'transaksi_keuangans';

    protected $fillable = [
        'judul',
        'tipe',
        'jumlah',
        'keterangan',
        'tingkat',
        'rt',
        'user_id',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}

}
