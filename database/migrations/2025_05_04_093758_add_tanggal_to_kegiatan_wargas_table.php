<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTanggalToKegiatanWargasTable extends Migration
{
    public function up()
    {
        Schema::table('kegiatan_wargas', function (Blueprint $table) {
            $table->date('tanggal')->nullable(); // Menambahkan kolom tanggal
        });
    }

    public function down()
    {
        Schema::table('kegiatan_wargas', function (Blueprint $table) {
            $table->dropColumn('tanggal'); // Menghapus kolom tanggal jika rollback
        });
    }
}
