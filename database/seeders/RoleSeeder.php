<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Membuat Role 'RT' jika belum ada
        $role = Role::firstOrCreate(['name' => 'RT']);

        // Membuat Permission 'manage reports' jika belum ada
        $permission = Permission::firstOrCreate(['name' => 'manage reports']);

        // Menambahkan permission ke role 'RT'
        $role->givePermissionTo($permission);
    }
}
