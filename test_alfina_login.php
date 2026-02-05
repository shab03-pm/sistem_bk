<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

echo "=== TEST LOGIN ALFINA ===\n\n";

$email = 'alfina.nurul.aprilliyani.10004@siswa.sekolah.id';
$password = 'siswa123456';

// 1. Check Siswa
echo "1️⃣ Check Siswa:\n";
$siswa = Siswa::where('email', $email)->first();
if ($siswa) {
    echo "   ✅ Found: ID={$siswa->id}, Nama={$siswa->nama}\n";
    echo "   Is Authenticatable: " . (is_a($siswa, \Illuminate\Contracts\Auth\Authenticatable::class) ? 'YES' : 'NO') . "\n";
    echo "   Password Match: " . (Hash::check($password, $siswa->password) ? 'YES' : 'NO') . "\n";

    // Simulate login
    Auth::login($siswa);
    $user = Auth::user();
    echo "   After Auth::login():\n";
    echo "     - auth()->user() type: " . class_basename($user) . "\n";
    echo "     - auth()->user()->id: " . $user->id . "\n";
    echo "     - auth()->user()->role: " . $user->role . "\n";
    echo "     - auth()->user()->name: " . $user->name . "\n";
} else {
    echo "   ❌ NOT FOUND\n";
}

// 2. Check User dengan email yg sama
echo "\n2️⃣ Check if User exists with same email:\n";
$user = User::where('email', $email)->first();
if ($user) {
    echo "   ❌ FOUND User: Role={$user->role}\n";
} else {
    echo "   ✅ No User with this email - GOOD\n";
}

// 3. Check overall User count
echo "\n3️⃣ Total Users in User table:\n";
echo "   " . User::count() . " users\n";
foreach (User::all() as $u) {
    echo "     - {$u->email} (role: {$u->role})\n";
}
