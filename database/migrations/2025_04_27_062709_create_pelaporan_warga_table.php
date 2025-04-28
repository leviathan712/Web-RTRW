<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelaporan_warga', function (Blueprint $table) {
            $table->id();
            $table->string('rt', 3)->nullable(); // RT pengirim laporan
            $table->enum('kategori', ['Keamanan', 'Kebersihan', 'Infrastruktur']);
            $table->text('deskripsi');
            $table->string('foto')->nullable(); // opsional upload foto
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelaporan_warga');
    }
};
