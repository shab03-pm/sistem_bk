<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\EloquentUserProvider;
use App\Auth\MultiModelUserProvider;

echo "=== ADMIN LOGIN SIMULATION ===\n\n";

// Get admin user
$admin = User::where('email', 'admin@sistem.com')->first();
echo "Step 1: Get Admin User\n";
echo "  Email: " . $admin->email . "\n";
echo "  ID: " . $admin->id . "\n";
echo "  Role: " . $admin->role . "\n\n";

// Simulate login - set session model type
echo "Step 2: Simulate Login\n";
Session::put('auth_model_type', 'user');
echo "  Set auth_model_type = 'user'\n\n";

// Now simulate session restoration using the provider
echo "Step 3: Restore User from Session (retrieveById)\n";
$provider = new MultiModelUserProvider(app('hash'), new User());

$restoredUser = $provider->retrieveById($admin->id);
echo "  Retrieved user class: " . get_class($restoredUser) . "\n";
echo "  Retrieved user ID: " . $restoredUser->id . "\n";
echo "  Retrieved user email: " . $restoredUser->email . "\n";
echo "  Retrieved user role: " . ($restoredUser->role ?? 'N/A') . "\n\n";

// Check if it's the admin user
if ($restoredUser instanceof User && $restoredUser->role === 'admin') {
    echo "✅ SUCCESS: Admin user restored correctly!\n";
    echo "   Role check would PASS for 'role:admin' middleware\n";
} else if ($restoredUser instanceof Siswa) {
    echo "❌ FAIL: Siswa user restored instead of Admin!\n";
    echo "   Role check would FAIL for 'role:admin' middleware\n";
    echo "   Siswa role: " . $restoredUser->role . "\n";
} else {
    echo "❌ FAIL: Unexpected user type\n";
}

echo "\n=== TEST WITH SISWA ===\n\n";

// Get a siswa user  
$siswa = Siswa::first();
echo "Step 1: Get Siswa User\n";
echo "  Nama: " . $siswa->nama . "\n";
echo "  ID: " . $siswa->id . "\n";
echo "  Role: " . $siswa->role . "\n\n";

// Simulate login - set session model type
echo "Step 2: Simulate Login\n";
Session::put('auth_model_type', 'siswa');
echo "  Set auth_model_type = 'siswa'\n\n";

// Now simulate session restoration using the provider
echo "Step 3: Restore User from Session (retrieveById)\n";
$restoredSiswa = $provider->retrieveById($siswa->id);
echo "  Retrieved user class: " . get_class($restoredSiswa) . "\n";
echo "  Retrieved user ID: " . $restoredSiswa->id . "\n";
echo "  Retrieved user nama: " . $restoredSiswa->nama . "\n";
echo "  Retrieved user role: " . $restoredSiswa->role . "\n\n";

// Check if it's the siswa user
if ($restoredSiswa instanceof Siswa) {
    echo "✅ SUCCESS: Siswa user restored correctly!\n";
} else {
    echo "❌ FAIL: Wrong user type restored!\n";
}
