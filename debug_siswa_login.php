<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

// Cek siswa dengan email tertentu
$email = 'ananda.senia.ramadhani.10403@siswa.sekolah.id';
$siswa = Siswa::where('email', $email)->first();

if ($siswa) {
    echo "✅ SISWA DITEMUKAN\n";
    echo "   NIS: " . $siswa->nis . "\n";
    echo "   Nama: " . $siswa->nama . "\n";
    echo "   Email: " . $siswa->email . "\n";
    echo "   Password Hash Length: " . strlen($siswa->password) . "\n";
    echo "   Password Hash: " . substr($siswa->password, 0, 20) . "...\n";

    // Test password check
    $password = 'siswa123456';
    $isMatch = Hash::check($password, $siswa->password);
    echo "   Password Match (siswa123456): " . ($isMatch ? '✅ YES' : '❌ NO') . "\n";
} else {
    echo "❌ SISWA TIDAK DITEMUKAN\n";
    echo "   Cek email yang ada di database:\n";
    $siswas = Siswa::limit(5)->get();
    foreach ($siswas as $s) {
        echo "   - " . $s->nis . " | " . $s->nama . " | " . $s->email . "\n";
    }
}
