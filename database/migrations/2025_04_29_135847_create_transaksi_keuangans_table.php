<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi_keuangans', function (Blueprint $table) {
            $table->id();
            $table->string('judul'); // contoh: Iuran Bulanan Warga
            $table->enum('tipe', ['pemasukan', 'pengeluaran']);
            $table->integer('jumlah'); // jumlah uang dalam rupiah
            $table->string('keterangan')->nullable();
            $table->enum('tingkat', ['RW', 'RT']); // tingkat transaksi
            $table->string('rt')->nullable(); // nullable untuk RW
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // pencatat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_keuangans');
    }
};
