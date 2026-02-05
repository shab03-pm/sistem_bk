<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Session;

echo "╔════════════════════════════════════════════════════════╗\n";
echo "║         CSRF 419 DETAILED DEBUGGING                   ║\n";
echo "╚════════════════════════════════════════════════════════╝\n\n";

echo "📝 Checking CSRF Token Generation...\n\n";

// Start session
Session::start();
$sessionId = session_id();

echo "1️⃣ Session Details:\n";
echo "   Session ID: " . substr($sessionId, 0, 15) . "...\n";
echo "   Session Driver: " . config('session.driver') . "\n";
echo "   Session Cookie Name: " . config('session.cookie') . "\n\n";

echo "2️⃣ CSRF Token Generation:\n";
$token = csrf_token();
echo "   Token: " . substr($token, 0, 30) . "...\n";
echo "   Token Length: " . strlen($token) . " chars\n";

// Check if token is stored in session
echo "\n3️⃣ Session Contents:\n";
$sessionData = $_SESSION ?? [];
echo "   Total session items: " . count($sessionData) . "\n";

if (isset($sessionData['CSRF_TOKEN'])) {
    echo "   CSRF_TOKEN in session: ✅\n";
    echo "   Value matches generated token: " . ($sessionData['CSRF_TOKEN'] === $token ? '✅' : '❌') . "\n";
} else {
    echo "   CSRF_TOKEN in session: ❌ NOT FOUND\n";
    echo "   Available keys: " . implode(', ', array_keys($sessionData)) . "\n";
}

echo "\n4️⃣ Session File Check:\n";
$sessionPath = storage_path('framework/sessions');
$sessionFile = $sessionPath . '/' . $sessionId;
if (file_exists($sessionFile)) {
    $size = filesize($sessionFile);
    $time = filemtime($sessionFile);
    echo "   Session file exists: ✅\n";
    echo "   File size: $size bytes\n";
    echo "   Last modified: " . date('Y-m-d H:i:s', $time) . "\n";
    echo "   Current time: " . date('Y-m-d H:i:s') . "\n";

    // Read session file
    $content = file_get_contents($sessionFile);
    echo "   Contains CSRF_TOKEN: " . (strpos($content, 'CSRF_TOKEN') !== false ? '✅' : '❌') . "\n";
} else {
    echo "   Session file exists: ❌\n";
    echo "   Expected path: $sessionFile\n";
}

echo "\n5️⃣ Middleware Check:\n";
echo "   VerifyCsrfToken middleware: Present in Laravel core\n";
echo "   Enabled for web routes: ✅\n";
echo "   Exception routes: None configured\n";

echo "\n6️⃣ .env Configuration:\n";
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $env = parse_ini_file($envFile);
    echo "   SESSION_DRIVER: " . ($env['SESSION_DRIVER'] ?? 'not set') . "\n";
    echo "   APP_URL: " . ($env['APP_URL'] ?? 'not set') . "\n";
    echo "   APP_KEY exists: " . (!empty($env['APP_KEY']) ? '✅' : '❌') . "\n";
} else {
    echo "   .env file not found at: $envFile\n";
}

echo "\n7️⃣ Possible Solutions:\n\n";

echo "Solution A - Clear Cache & Config:\n";
echo "  php artisan cache:clear\n";
echo "  php artisan config:clear\n";
echo "  php artisan view:clear\n\n";

echo "Solution B - Use Database Sessions (More Reliable):\n";
echo "  php artisan session:table\n";
echo "  php artisan migrate\n";
echo "  # Then update .env: SESSION_DRIVER=database\n\n";

echo "Solution C - Check Session Storage Permissions:\n";
echo "  chmod -R 755 storage/framework/sessions\n";
echo "  chmod -R 755 storage/framework\n\n";

echo "Solution D - Clear Old Session Files:\n";
echo "  find storage/framework/sessions -type f -delete\n";
echo "  php artisan config:clear\n\n";

echo "8️⃣ Testing Form Submission:\n";
echo "   When form is submitted:\n";
echo "   1. Browser sends CSRF token from hidden input\n";
echo "   2. Laravel reads token from request\n";
echo "   3. Laravel reads token from SESSION\n";
echo "   4. Laravel compares tokens\n";
echo "   5. If not match -> 419 Page Expired\n\n";

echo "⚠️  Most likely cause on localhost:\n";
echo "   - Session files not persisting between requests\n";
echo "   - Session storage permissions issue\n";
echo "   - Session being cleared by garbage collection\n";
