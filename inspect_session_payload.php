<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "╔════════════════════════════════════════════════════════╗\n";
echo "║      INSPECTING SESSION PAYLOAD STRUCTURE            ║\n";
echo "╚════════════════════════════════════════════════════════╝\n\n";

// Get last session
$session = DB::table('sessions')
    ->orderBy('last_activity', 'desc')
    ->first();

if ($session) {
    echo "Session ID: " . $session->id . "\n\n";

    // Decode the payload
    $decoded = base64_decode($session->payload);
    $data = unserialize($decoded);

    echo "Payload Structure:\n";
    echo "═══════════════════\n";

    foreach ($data as $key => $value) {
        if (is_array($value)) {
            echo "$key:\n";
            foreach ($value as $k => $v) {
                echo "  - $k: " . substr((string) $v, 0, 40) . (strlen((string) $v) > 40 ? '...' : '') . "\n";
            }
        } else {
            echo "$key: " . substr((string) $value, 0, 60) . (strlen((string) $value) > 60 ? '...' : '') . "\n";
        }
    }

    echo "\n\n📝 Key Findings:\n";
    echo "════════════════\n";

    if (isset($data['_token'])) {
        echo "✅ _token found (Laravel 11 style!)\n";
        echo "   Value: " . $data['_token'] . "\n";
    }

    if (isset($data['CSRF_TOKEN'])) {
        echo "✅ CSRF_TOKEN found (Laravel 10 style)\n";
    }

    if (!isset($data['_token']) && !isset($data['CSRF_TOKEN'])) {
        echo "❌ No CSRF token found in session!\n";
    }

    echo "\n\n🔍 Analysis:\n";
    echo "═════════════\n";
    echo "Laravel 11 stores CSRF token as '_token' not 'CSRF_TOKEN'\n";
    echo "The VerifyCsrfToken middleware should look for '_token'\n";
    echo "This should work correctly with @csrf directive\n\n";

    echo "If 419 still occurs:\n";
    echo "1. The form might not be sending _token\n";
    echo "2. The middleware might not be running\n";
    echo "3. Session might not be persisting\n";

} else {
    echo "No sessions found in database!\n";
}
