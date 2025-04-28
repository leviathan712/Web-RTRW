<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_warga', function (Blueprint $table) {
            $table->string('rt', 3)->change();
        });
    }

    public function down(): void
    {
        Schema::table('data_warga', function (Blueprint $table) {
            $table->integer('rt')->change();
        });
    }
};
