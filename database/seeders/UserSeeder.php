<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'admin@sistem.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'guru@sistem.com'],
            [
                'name' => 'Guru BK',
                'password' => Hash::make('password'),
                'role' => 'guru_bk',
            ]
        );

        User::firstOrCreate(
            ['email' => 'siswa@sistem.com'],
            [
                'name' => 'Siswa',
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ]
        );
    }
}
