<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

$email = 'alfina.nurul.aprilliyani.10004@siswa.sekolah.id';
$password = 'siswa123456';

echo "=== TEST MANUAL LOGIN ===\n\n";

// Test 1: Manual find and password check
echo "1️⃣ Manual Siswa Check:\n";
$siswa = Siswa::where('email', $email)->first();
if ($siswa && Hash::check($password, $siswa->password)) {
    echo "   ✅ Siswa found and password match\n";
    echo "   Siswa ID: " . $siswa->id . "\n";
    echo "   Siswa Nama: " . $siswa->nama . "\n";
    echo "   Siswa Role: " . $siswa->role . "\n";
    echo "   Is Authenticatable: " . (is_a($siswa, \Illuminate\Contracts\Auth\Authenticatable::class) ? 'YES' : 'NO') . "\n";
} else {
    echo "   ❌ Failed\n";
}

// Test 2: Try Auth::login()
echo "\n2️⃣ Test Auth::login() with Siswa:\n";
try {
    Auth::login($siswa);
    $user = Auth::user();
    echo "   ✅ Auth::login() berhasil\n";
    echo "   Auth::user() type: " . class_basename($user) . "\n";
    echo "   Auth::user()->id: " . $user->id . "\n";
    echo "   Auth::user()->role: " . $user->role . "\n";
    echo "   Auth::user()->name: " . $user->name . "\n";
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

// Test 3: Check User model juga
echo "\n3️⃣ Check User model password untuk email yg sama:\n";
$user = User::where('email', $email)->first();
if (!$user) {
    echo "   ✅ Tidak ada User dengan email ini\n";
} else {
    echo "   ❌ Ada User dengan email ini!\n";
}
