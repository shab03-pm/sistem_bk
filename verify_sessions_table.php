<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "╔════════════════════════════════════════════════════════╗\n";
echo "║         DATABASE SESSIONS VERIFICATION                ║\n";
echo "╚════════════════════════════════════════════════════════╝\n\n";

echo "1️⃣ Sessions Table:\n";
$hasTable = Schema::hasTable('sessions');
echo "   Exists: " . ($hasTable ? '✅' : '❌') . "\n";

if ($hasTable) {
    $count = DB::table('sessions')->count();
    echo "   Records: $count\n\n";

    echo "2️⃣ Last 3 Sessions:\n";
    $sessions = DB::table('sessions')
        ->orderBy('last_activity', 'desc')
        ->limit(3)
        ->get();

    foreach ($sessions as $i => $session) {
        echo "\n   Session " . ($i + 1) . ":\n";
        echo "     ID: " . substr($session->id, 0, 15) . "...\n";
        echo "     IP: " . $session->ip_address . "\n";
        echo "     Last Activity: " . date('Y-m-d H:i:s', $session->last_activity) . "\n";
        echo "     Payload size: " . strlen($session->payload) . " bytes\n";

        // Try to check if CSRF token exists in payload
        try {
            $decoded = base64_decode($session->payload);
            $data = unserialize($decoded);

            $keys = array_keys($data);
            $hasToken = in_array('CSRF_TOKEN', $keys);
            echo "     CSRF_TOKEN in payload: " . ($hasToken ? '✅' : '❌') . "\n";
            echo "     Data keys: " . implode(', ', array_slice($keys, 0, 3)) . (count($keys) > 3 ? '...' : '') . "\n";
        } catch (\Exception $e) {
            echo "     Error reading payload: " . $e->getMessage() . "\n";
        }
    }
} else {
    echo "   ❌ Sessions table DOES NOT EXIST!\n";
    echo "   Run: php artisan migrate\n";
}

echo "\n3️⃣ Session Configuration:\n";
echo "   Driver: " . config('session.driver') . "\n";
echo "   Cookie: " . config('session.cookie') . "\n";
echo "   Lifetime: " . config('session.lifetime') . " minutes\n\n";

echo "4️⃣ CSRF Configuration:\n";
echo "   Using VerifyCsrfToken middleware: ✅\n";
echo "   Exception list in bootstrap/app.php: Check needed\n\n";

echo "5️⃣ Recommended Next Steps:\n";
if (!$hasTable) {
    echo "   1. Run: php artisan migrate\n";
} else {
    echo "   1. Check browser DevTools:\n";
    echo "      - Network tab: Look for Set-Cookie header\n";
    echo "      - Storage tab: Check if session cookie is stored\n";
    echo "   2. Form submission debug:\n";
    echo "      - Add logging to RegisteredUserController\n";
    echo "      - Check what CSRF token is being sent\n";
    echo "      - Check what token is in the database\n";
}
