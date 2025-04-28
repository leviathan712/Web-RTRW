<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin RW',
            'email' => 'admin@rw.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Ketua RT 01',
            'email' => 'rt01@rw.test',
            'password' => Hash::make('password'),
            'role' => 'rt',
        ]);

        User::create([
            'name' => 'Ketua RW',
            'email' => 'rw@rw.test',
            'password' => Hash::make('password'),
            'role' => 'rw',
        ]);

        User::create([
            'name' => 'Warga 1',
            'email' => 'warga1@rw.test',
            'password' => Hash::make('password'),
            'role' => 'warga',
            'rt' => 1,
        ]);
    }
}
