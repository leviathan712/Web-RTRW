<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveLokasiFromKegiatanWargas extends Migration
{
    public function up()
    {
        Schema::table('kegiatan_wargas', function (Blueprint $table) {
            $table->dropColumn('lokasi');
        });
    }

    public function down()
    {
        Schema::table('kegiatan_wargas', function (Blueprint $table) {
            $table->string('lokasi')->nullable();  // jika ingin mengembalikan kolom jika rollback
        });
    }
}