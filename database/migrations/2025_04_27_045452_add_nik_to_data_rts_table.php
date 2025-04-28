<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNikToDataRtsTable extends Migration
{
    public function up(): void
    {
        Schema::table('data_rts', function (Blueprint $table) {
            $table->string('nik')->after('id'); // Menambahkan kolom nik setelah kolom id
        });
    }

    public function down(): void
    {
        Schema::table('data_rts', function (Blueprint $table) {
            $table->dropColumn('nik'); // Menghapus kolom nik jika migrasi dibatalkan
        });
    }
}
