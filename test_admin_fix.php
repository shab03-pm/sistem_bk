<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

echo "=== ADMIN LOGIN FIX VERIFICATION ===\n\n";

// Get admin user
$admin = User::where('email', 'admin@sistem.com')->first();
echo "Admin User Details:\n";
echo "  ID: " . $admin->id . "\n";
echo "  Email: " . $admin->email . "\n";
echo "  Role: " . $admin->role . "\n";
echo "  Password Hash: " . substr($admin->password, 0, 20) . "...\n\n";

// Verify password test
echo "Password Verification Test:\n";
$testPassword = 'password'; // Default password from seeder
if (Hash::check($testPassword, $admin->password)) {
    echo "  ✅ Password 'password' is correct\n\n";
} else {
    echo "  ❌ Password verification failed\n\n";
}

// Check ID collision
echo "ID Collision Check:\n";
$siswaWithSameId = Siswa::where('id', $admin->id)->first();
if ($siswaWithSameId) {
    echo "  ⚠️  Siswa with same ID (1) exists: " . $siswaWithSameId->nama . "\n";
    echo "     This was causing the 403 error!\n\n";
} else {
    echo "  ✅ No Siswa with admin's ID\n\n";
}

// Test the fix
echo "Authentication Flow Test:\n";
echo "1️⃣  Simulating admin login...\n";

// Clear any previous auth
Auth::logout();
Session::flush();

// Try to login
$credentials = [
    'email' => 'admin@sistem.com',
    'password' => 'password'
];

// Use the auth controller logic
$adminUser = User::where('email', $credentials['email'])->first();
if ($adminUser && Hash::check($credentials['password'], $adminUser->password)) {
    Auth::login($adminUser);
    Session::put('auth_model_type', 'user');
    echo "   ✅ Login successful\n";
    echo "   Session model type: " . Session::get('auth_model_type') . "\n\n";

    echo "2️⃣  Checking auth after login...\n";
    echo "   Authenticated: " . (Auth::check() ? 'Yes' : 'No') . "\n";
    echo "   User ID: " . Auth::id() . "\n";
    echo "   User Role: " . Auth::user()->role . "\n\n";

    echo "3️⃣  Simulating page reload (session restoration)...\n";
    $userId = Auth::id();

    // Simulate what Laravel does on next request - it calls retrieveById
    $guard = Auth::guard('web');
    $provider = $guard->getProvider();

    // This should restore the admin user (not the siswa with ID 1)
    $restoredUser = $provider->retrieveById($userId);
    echo "   Retrieved user type: " . class_basename(get_class($restoredUser)) . "\n";
    echo "   Retrieved user role: " . ($restoredUser->role ?? 'N/A') . "\n\n";

    if ($restoredUser instanceof User && $restoredUser->role === 'admin') {
        echo "✅ FIX SUCCESSFUL!\n";
        echo "   The admin user is correctly restored from session\n";
        echo "   The 'role:admin' middleware will now PASS\n";
    } else if ($restoredUser instanceof Siswa) {
        echo "❌ FIX FAILED!\n";
        echo "   Siswa was restored instead of Admin user\n";
        echo "   The 'role:admin' middleware will FAIL with 403\n";
    }
} else {
    echo "   ❌ Login failed\n";
}
