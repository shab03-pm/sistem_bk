<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

$email = 'alfina.nurul.aprilliyani.10004@siswa.sekolah.id';

echo "=== DEBUG LOGIN ===\n\n";

// Check User model
$user = User::where('email', $email)->first();
if ($user) {
    echo "❌ PROBLEM FOUND:\n";
    echo "   Ada User dengan email: $email\n";
    echo "   User ID: " . $user->id . "\n";
    echo "   User Role: " . $user->role . "\n";
    echo "   User Password Hash: " . substr($user->password, 0, 20) . "...\n";
    echo "\n   SOLUTION: Hapus User ini atau ubah emailnya\n\n";
} else {
    echo "✅ Tidak ada User dengan email ini - GOOD\n\n";
}

// Check Siswa model
$siswa = Siswa::where('email', $email)->first();
if ($siswa) {
    echo "✅ Siswa ditemukan:\n";
    echo "   Siswa ID: " . $siswa->id . "\n";
    echo "   Siswa Nama: " . $siswa->nama . "\n";
    echo "   Siswa Password Hash: " . substr($siswa->password, 0, 20) . "...\n";

    // Test password check
    $password = 'siswa123456';
    $isMatch = Hash::check($password, $siswa->password);
    echo "   Password Match: " . ($isMatch ? '✅ YES' : '❌ NO') . "\n";
    echo "   Siswa Model extends Authenticatable: " . (is_a($siswa, \Illuminate\Foundation\Auth\User::class) ? '✅ YES' : '❌ NO') . "\n";
} else {
    echo "❌ Siswa tidak ditemukan\n";
}
