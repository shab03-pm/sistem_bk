<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

echo "╔════════════════════════════════════════════════════════╗\n";
echo "║          CSRF & SESSION FLOW DIAGNOSTIC               ║\n";
echo "╚════════════════════════════════════════════════════════╝\n\n";

echo "1️⃣ Session Configuration:\n";
echo "   Driver: " . config('session.driver') . "\n";
echo "   Lifetime: " . config('session.lifetime') . " minutes\n\n";

echo "2️⃣ Database Sessions Table Status:\n";
try {
    $count = DB::table('sessions')->count();
    echo "   Sessions in database: $count\n";

    // Check a recent session
    $recent = DB::table('sessions')
        ->orderBy('last_activity', 'desc')
        ->first();

    if ($recent) {
        $timeAgo = time() - $recent->last_activity;
        echo "   Most recent session:\n";
        echo "     - ID: " . substr($recent->id, 0, 15) . "...\n";
        echo "     - Last activity: " . abs($timeAgo) . " seconds ago\n";
        echo "     - Has data: " . (strlen($recent->payload ?? '') > 0 ? 'Yes' : 'No') . "\n";
    }
} catch (\Exception $e) {
    echo "   Error checking sessions: " . $e->getMessage() . "\n";
}

echo "\n3️⃣ Common 419 Reasons in Laravel 11:\n";
echo "   ✓ CSRF token not in form\n";
echo "   ✓ Session not created before form rendering\n";
echo "   ✓ Session token mismatch\n";
echo "   ✓ Session cookie not set in response\n";
echo "   ✓ Token expired (session lifetime)\n\n";

echo "4️⃣ Proposed Solutions:\n\n";

echo "Solution A - Add explicit CSRF exception (temporary):\n";
echo "  In bootstrap/app.php:\n";
echo "  ->withMiddleware(function (Middleware \$middleware) {\n";
echo "      \$middleware->validateCsrfTokens(\n";
echo "          except: ['/register']\n";
echo "      );\n";
echo "  })\n\n";

echo "Solution B - Verify Sessions Table:\n";
echo "  php artisan migrate:fresh (only if needed)\n";
echo "  php artisan migrate\n\n";

echo "Solution C - Test with a simple form:\n";
echo "  Try POST to /login first to see if CSRF works there\n\n";

echo "5️⃣ Debug the Register Endpoint:\n";
echo "   GET /register -> Should create session & set cookie\n";
echo "   POST /register with form -> Should validate CSRF\n";
echo "   Check browser DevTools:\n";
echo "     - Network tab: Response headers for Set-Cookie\n";
echo "     - Storage tab: Check if session cookie exists\n";
echo "     - Form data: Verify _token is present\n\n";

echo "6️⃣ Immediate Fix to Try:\n";
echo "   Clear all browser cookies\n";
echo "   Hard refresh (Ctrl+Shift+R)\n";
echo "   Try registration again\n";
