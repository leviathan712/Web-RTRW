<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Membuat role-role jika belum ada
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $rw = Role::firstOrCreate(['name' => 'RW']);
        $rt = Role::firstOrCreate(['name' => 'RT']);
        $warga = Role::firstOrCreate(['name' => 'Warga']);

        // Membuat permission-permission jika belum ada
        $manageFinancials = Permission::firstOrCreate(['name' => 'manage financials']);
        $manageReports = Permission::firstOrCreate(['name' => 'manage reports']);
        $viewReports = Permission::firstOrCreate(['name' => 'view reports']);
        $manageUsers = Permission::firstOrCreate(['name' => 'manage users']);
        $manageWargaData = Permission::firstOrCreate(['name' => 'manage warga data']);
        $manageRTData = Permission::firstOrCreate(['name' => 'manage rt data']);
        $manageRWData = Permission::firstOrCreate(['name' => 'manage rw data']);
        $manageNews = Permission::firstOrCreate(['name' => 'manage news']);

        // Menambahkan permissions ke role masing-masing
        // Admin punya akses penuh
        $admin->givePermissionTo([
            $manageFinancials,
            $manageReports,
            $viewReports,
            $manageUsers,
            $manageWargaData,
            $manageRTData,
            $manageRWData,
            $manageNews,
        ]);

        // RW bisa mengelola keuangan dan laporan, serta melihat laporan, data RW dan Warga
        $rw->givePermissionTo([
            $manageFinancials,
            $manageReports,
            $viewReports,
            $manageRWData,
            $manageWargaData,
        ]);

        // RT bisa mengelola keuangan, melihat laporan sesuai RT-nya, dan mengelola data RT dan Warga
        $rt->givePermissionTo([
            $viewReports,
            $manageFinancials,
            $manageRTData,
            $manageWargaData,
        ]);

        // Warga hanya bisa melihat laporan
        $warga->givePermissionTo($viewReports);
    }
}
