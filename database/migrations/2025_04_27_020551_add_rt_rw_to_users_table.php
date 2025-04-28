<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'rt')) {
                $table->integer('rt')->nullable()->after('email');
            }

            if (!Schema::hasColumn('users', 'rw')) {
                $table->integer('rw')->default(5)->after('rt');
            }

            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('warga')->after('rw');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'rt')) {
                $table->dropColumn('rt');
            }

            if (Schema::hasColumn('users', 'rw')) {
                $table->dropColumn('rw');
            }

            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
