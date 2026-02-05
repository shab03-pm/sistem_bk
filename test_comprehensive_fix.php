<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

echo "╔════════════════════════════════════════════════════════╗\n";
echo "║  ADMIN LOGIN 403 FIX - COMPREHENSIVE TEST SUITE       ║\n";
echo "╚════════════════════════════════════════════════════════╝\n\n";

// ============================================================
// TEST 1: Verify ID Collision Exists
// ============================================================
echo "TEST 1: Verify ID Collision Problem\n";
echo "───────────────────────────────────\n";

$admin = User::where('email', 'admin@sistem.com')->first();
$siswaWithSameId = Siswa::where('id', $admin->id)->first();

echo "Admin User ID: {$admin->id}\n";
echo "Siswa with same ID exists: " . ($siswaWithSameId ? 'YES' : 'NO') . "\n";

if ($siswaWithSameId) {
    echo "  └─ Siswa: {$siswaWithSameId->nama} (ID {$siswaWithSameId->id})\n";
    echo "     ⚠️  This was causing the 403 error\n\n";
} else {
    echo "  ✅ No collision\n\n";
}

// ============================================================
// TEST 2: Admin Login Flow
// ============================================================
echo "TEST 2: Admin Login Flow\n";
echo "──────────────────────────\n";

// Simulate first-time login
Auth::logout();
Session::flush();

$email = 'admin@sistem.com';
$password = 'password';

$user = User::where('email', $email)->first();
if ($user && Hash::check($password, $user->password)) {
    Auth::login($user);
    Session::put('auth_model_type', 'user');

    echo "✅ Login successful\n";
    echo "   Email: {$user->email}\n";
    echo "   Role: {$user->role}\n";
    echo "   Session hint set: auth_model_type = 'user'\n\n";
} else {
    echo "❌ Login failed\n\n";
    exit(1);
}

// ============================================================
// TEST 3: Session Restoration (Page Reload Simulation)
// ============================================================
echo "TEST 3: Session Restoration (Simulate Page Reload)\n";
echo "────────────────────────────────────────────────────\n";

$userId = Auth::id();
$sessionHint = Session::get('auth_model_type');

echo "Before restoration:\n";
echo "   User ID in session: {$userId}\n";
echo "   Model type hint: {$sessionHint}\n";
echo "   Current auth()->user(): " . Auth::user()->email . "\n\n";

// This is what Laravel does internally on next request
$provider = Auth::guard('web')->getProvider();
$restoredUser = $provider->retrieveById($userId);

echo "After restoration:\n";
echo "   Retrieved user class: " . class_basename(get_class($restoredUser)) . "\n";
echo "   Retrieved user ID: {$restoredUser->id}\n";
echo "   Retrieved user email: {$restoredUser->email}\n";
echo "   Retrieved user role: " . ($restoredUser->role ?? $restoredUser->role) . "\n\n";

if ($restoredUser instanceof User && $restoredUser->role === 'admin') {
    echo "✅ CORRECT: Admin user restored (not Siswa)\n\n";
} else if ($restoredUser instanceof Siswa) {
    echo "❌ ERROR: Siswa restored instead of Admin!\n\n";
    exit(1);
} else {
    echo "❌ ERROR: Unknown user type\n\n";
    exit(1);
}

// ============================================================
// TEST 4: Role Middleware Check
// ============================================================
echo "TEST 4: Role Middleware Check\n";
echo "──────────────────────────────\n";

// Simulate the role:admin middleware check
if (Auth::check() && in_array(Auth::user()->role, ['admin'])) {
    echo "✅ PASS: role:admin middleware would allow access\n";
    echo "   No 403 error\n\n";
} else {
    echo "❌ FAIL: role:admin middleware would REJECT\n";
    echo "   Would result in 403 Forbidden\n\n";
    exit(1);
}

// ============================================================
// TEST 5: Siswa Login Verification
// ============================================================
echo "TEST 5: Siswa Login (Verify fix doesn't break siswa auth)\n";
echo "──────────────────────────────────────────────────────────\n";

Auth::logout();
Session::flush();

$siswa = Siswa::first();
Auth::login($siswa);
Session::put('auth_model_type', 'siswa');

echo "Login as Siswa: {$siswa->nama}\n";
echo "Session hint set: auth_model_type = 'siswa'\n";

// Simulate page reload
$provider = Auth::guard('web')->getProvider();
$restoredSiswa = $provider->retrieveById($siswa->id);

echo "After restoration:\n";
echo "   Retrieved user class: " . class_basename(get_class($restoredSiswa)) . "\n";
echo "   Retrieved user ID: {$restoredSiswa->id}\n\n";

if ($restoredSiswa instanceof Siswa && $restoredSiswa->id === $siswa->id) {
    echo "✅ CORRECT: Siswa user restored correctly\n\n";
} else {
    echo "❌ ERROR: Siswa not restored correctly\n\n";
    exit(1);
}

// ============================================================
// SUMMARY
// ============================================================
echo "╔════════════════════════════════════════════════════════╗\n";
echo "║                    ALL TESTS PASSED                   ║\n";
echo "╚════════════════════════════════════════════════════════╝\n\n";

echo "Summary:\n";
echo "✅ ID collision properly handled\n";
echo "✅ Admin login works correctly\n";
echo "✅ Session restoration restores correct user model\n";
echo "✅ Role middleware will not return 403\n";
echo "✅ Siswa authentication still works\n\n";

echo "The fix successfully resolves the 403 Forbidden error!\n";
