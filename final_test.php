<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

$email = 'alfina.nurul.aprilliyani.10004@siswa.sekolah.id';
$password = 'siswa123456';

echo "=== FINAL LOGIN TEST ===\n\n";

// 1. Check Siswa
$siswa = Siswa::where('email', $email)->first();
echo "1️⃣ Siswa check:\n";
if ($siswa) {
    $passOK = Hash::check($password, $siswa->password);
    echo "   ✅ Found: ID={$siswa->id}, Nama={$siswa->nama}\n";
    echo "   Password: " . ($passOK ? '✅ MATCH' : '❌ MISMATCH') . "\n";
} else {
    echo "   ❌ Not found\n";
}

// 2. Check User
$user = User::where('email', $email)->first();
echo "\n2️⃣ User check:\n";
if ($user) {
    echo "   ❌ Found User with same email (PROBLEM!): role={$user->role}\n";
} else {
    echo "   ✅ No User with this email - GOOD\n";
}

// 3. Check by NIS
echo "\n3️⃣ NIS check:\n";
$siswaByNIS = Siswa::where('nis', '10004')->first();
if ($siswaByNIS) {
    echo "   ✅ Found by NIS 10004: {$siswaByNIS->nama}\n";
} else {
    echo "   ❌ Not found by NIS\n";
}

// 4. Check all siswa count
echo "\n4️⃣ Database counts:\n";
echo "   Total Siswa: " . Siswa::count() . "\n";
echo "   Total User: " . User::count() . "\n";
