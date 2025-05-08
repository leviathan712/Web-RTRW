<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kegiatan_wargas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_pelaksanaan');
            $table->string('lokasi');
            $table->enum('status_pelaksanaan', ['1', '5']); // 1 = Direncanakan, 5 = Selesai
            $table->string('rt'); // relasi berdasarkan rt string seperti '001', '002'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatan_wargas');
    }
};
