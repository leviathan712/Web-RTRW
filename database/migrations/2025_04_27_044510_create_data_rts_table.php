<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataRtsTable extends Migration
{
    public function up(): void
    {
        Schema::create('data_rts', function (Blueprint $table) {
            $table->id();
            $table->string('rt', 3)->unique(); // RT dalam format 3 digit
            $table->string('nama_rt'); // Nama RT
            $table->text('alamat_rt'); // Alamat RT
            $table->string('periode_jabatan'); // Periode jabatan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_rts');
    }
}
