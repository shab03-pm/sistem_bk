<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FixAdminRoleSeeder extends Seeder
{
    public function run()
    {
        // Ensure admin user exists with correct role
        $admin = User::where('email', 'admin@sistem.com')->first();

        if ($admin) {
            // Update role to admin if not already
            if ($admin->role !== 'admin') {
                $admin->update(['role' => 'admin']);
                echo "✓ Updated admin user role to 'admin'\n";
            } else {
                echo "✓ Admin user already has correct role\n";
            }
        } else {
            // Create admin user if doesn't exist
            User::create([
                'name' => 'Admin',
                'email' => 'admin@sistem.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
            echo "✓ Created new admin user\n";
        }

        // Ensure guru_bk user exists with correct role
        $guru = User::where('email', 'guru@sistem.com')->first();

        if ($guru) {
            if ($guru->role !== 'guru_bk') {
                $guru->update(['role' => 'guru_bk']);
                echo "✓ Updated guru_bk user role to 'guru_bk'\n";
            } else {
                echo "✓ Guru BK user already has correct role\n";
            }
        } else {
            User::create([
                'name' => 'Guru BK',
                'email' => 'guru@sistem.com',
                'password' => Hash::make('password'),
                'role' => 'guru_bk',
            ]);
            echo "✓ Created new guru_bk user\n";
        }

        // Ensure siswa user exists with correct role
        $siswa = User::where('email', 'siswa@sistem.com')->first();

        if ($siswa) {
            if ($siswa->role !== 'siswa') {
                $siswa->update(['role' => 'siswa']);
                echo "✓ Updated siswa user role to 'siswa'\n";
            } else {
                echo "✓ Siswa user already has correct role\n";
            }
        } else {
            User::create([
                'name' => 'Siswa',
                'email' => 'siswa@sistem.com',
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ]);
            echo "✓ Created new siswa user\n";
        }

        echo "\n✅ All users verified with correct roles!\n";
    }
}
