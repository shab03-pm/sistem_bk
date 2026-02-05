<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

echo "=== SIMULATE ALFINA LOGIN ===\n\n";

// Simulate request
$request = new Request([
    'login' => 'alfina.nurul.aprilliyani.10004@siswa.sekolah.id',
    'password' => 'siswa123456',
]);

// Manually run the controller logic
$loginType = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'nis';

echo "1️⃣ Login input: " . $request->input('login') . "\n";
echo "   Login type: $loginType\n\n";

// Try authenticate with Siswa model FIRST
$siswa = \App\Models\Siswa::where($loginType, $request->input('login'))->first();
if ($siswa && \Illuminate\Support\Facades\Hash::check($request->input('password'), $siswa->password)) {
    echo "2️⃣ ✅ Siswa found and password match!\n";
    echo "   Siswa ID: " . $siswa->id . "\n";
    echo "   Siswa Nama: " . $siswa->nama . "\n";

    Auth::login($siswa);
    $request->session()->regenerate();

    $user = Auth::user();
    echo "\n3️⃣ After Auth::login() + session regenerate:\n";
    echo "   auth()->user() type: " . class_basename($user) . "\n";
    echo "   auth()->user()->id: " . $user->id . "\n";
    echo "   auth()->user()->role: " . $user->role . "\n";
    echo "   auth()->user()->name: " . $user->name . "\n";

    echo "\n4️⃣ Redirect will be to: /siswa/dashboard\n";
} else {
    echo "2️⃣ ❌ Siswa not found or password mismatch\n";
}
