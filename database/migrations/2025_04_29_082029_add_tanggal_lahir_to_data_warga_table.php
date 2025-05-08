<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('data_warga', function (Blueprint $table) {
            $table->date('tanggal_lahir')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('data_warga', function (Blueprint $table) {
            $table->dropColumn('tanggal_lahir');
        });
    }
};
