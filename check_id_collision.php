<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Siswa;

echo "=== ID COLLISION CHECK ===\n\n";

// Get first admin user
$admin = User::where('role', 'admin')->first();
echo "Admin User:\n";
echo "  ID: " . ($admin->id ?? 'None') . "\n";
echo "  Email: " . ($admin->email ?? 'None') . "\n";
echo "  Role: " . ($admin->role ?? 'None') . "\n";

if ($admin) {
    // Check if there's a Siswa with the same ID
    $siswa = Siswa::where('id', $admin->id)->first();
    echo "\nSiswa with same ID:\n";
    if ($siswa) {
        echo "  ✅ FOUND! This is the problem!\n";
        echo "  ID: " . $siswa->id . "\n";
        echo "  Nama: " . $siswa->nama . "\n";
        echo "  Email: " . $siswa->email . "\n";
        echo "  Role: " . ($siswa->role ?? 'null') . "\n";
    } else {
        echo "  ❌ Not found - no collision\n";
    }
}

echo "\n=== ID DISTRIBUTION ===\n";
$userCount = User::count();
$siswaCount = Siswa::count();
echo "Total Users: " . $userCount . "\n";
echo "Total Siswas: " . $siswaCount . "\n";

$adminCount = User::where('role', 'admin')->count();
$guruCount = User::where('role', 'guru_bk')->count();
echo "\nUsers breakdown:\n";
echo "  Admin: " . $adminCount . "\n";
echo "  Guru BK: " . $guruCount . "\n";

echo "\nFirst 5 User IDs: ";
echo implode(', ', User::limit(5)->pluck('id')->toArray());
echo "\n";

echo "First 5 Siswa IDs: ";
echo implode(', ', Siswa::limit(5)->pluck('id')->toArray());
echo "\n";

// Check if IDs overlap
$userIds = User::pluck('id')->toArray();
$siswaIds = Siswa::pluck('id')->toArray();
$overlapping = array_intersect($userIds, $siswaIds);

if (count($overlapping) > 0) {
    echo "\n❌ CRITICAL: Overlapping IDs found: " . implode(', ', $overlapping) . "\n";
} else {
    echo "\n✅ No overlapping IDs - this is good!\n";
}
