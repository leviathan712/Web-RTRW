<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateEnumRoleOnUsersTable extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'rt', 'rw', 'warga') NOT NULL DEFAULT 'warga'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'rt', 'warga') NOT NULL DEFAULT 'warga'");
    }
}
