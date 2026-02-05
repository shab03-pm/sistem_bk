<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== SESSION & CSRF DEBUG ===\n\n";

echo "1️⃣ Session Configuration:\n";
echo "   Driver: " . config('session.driver') . "\n";
echo "   Lifetime: " . config('session.lifetime') . " minutes\n";
echo "   Path: " . config('session.files') . "\n";
echo "   Cookie: " . config('session.cookie') . "\n";
echo "   Domain: " . config('session.domain') . "\n";
echo "   Path: " . config('session.path') . "\n";
echo "   Secure: " . (config('session.secure') ? 'Yes' : 'No') . "\n";
echo "   Http Only: " . (config('session.http_only') ? 'Yes' : 'No') . "\n\n";

echo "2️⃣ Session Storage:\n";
$sessionPath = storage_path('framework/sessions');
echo "   Session directory: $sessionPath\n";
if (is_dir($sessionPath)) {
    echo "   Exists: ✅\n";
    echo "   Writable: " . (is_writable($sessionPath) ? '✅' : '❌') . "\n";
    $files = glob($sessionPath . '/*');
    $sessionFiles = array_filter($files, fn($f) => is_file($f) && basename($f) !== '.gitignore');
    echo "   Session files: " . count($sessionFiles) . "\n";
} else {
    echo "   Exists: ❌\n";
}

echo "\n3️⃣ CSRF Configuration:\n";
echo "   Enabled: " . (config('app.csrf_token') ? 'Yes' : 'N/A') . "\n";
echo "   Session name: " . config('session.cookie') . "\n";

echo "\n4️⃣ APP Configuration:\n";
echo "   APP_URL: " . config('app.url') . "\n";
echo "   APP_DEBUG: " . (config('app.debug') ? 'Yes' : 'No') . "\n";

echo "\n5️⃣ Environment Check:\n";
echo "   APP_ENV: " . config('app.env') . "\n";
echo "   APP_KEY exists: " . (config('app.key') ? '✅' : '❌') . "\n";

echo "\n6️⃣ Possible Issues:\n";

$issues = [];

if (config('session.driver') !== 'file') {
    $issues[] = "Session driver is '" . config('session.driver') . "' - make sure it's properly configured";
}

if (!is_writable($sessionPath)) {
    $issues[] = "Session directory is not writable - check permissions";
}

if (config('session.secure') && !str_starts_with(config('app.url'), 'https')) {
    $issues[] = "Session is set to secure but APP_URL is not HTTPS - this will block cookies on localhost";
}

if (config('session.http_only') === false) {
    $issues[] = "HTTP_ONLY is disabled - cookies accessible to JavaScript (security risk)";
}

if (empty(config('app.key'))) {
    $issues[] = "APP_KEY is empty - CSRF token generation will fail";
}

if (count($issues) === 0) {
    echo "   ✅ No obvious issues detected\n\n";
    echo "   Common 419 causes:\n";
    echo "   - Session files getting deleted before form submission\n";
    echo "   - Session lifetime is too short\n";
    echo "   - Browser not accepting cookies\n";
    echo "   - Form takes too long to fill (session expires)\n";
} else {
    echo "   ⚠️  Issues found:\n";
    foreach ($issues as $issue) {
        echo "     - $issue\n";
    }
}

echo "\n7️⃣ Recommendations:\n";
echo "   1. Check .env file for correct APP_URL (should be http://127.0.0.1:8000 for local)\n";
echo "   2. Verify SESSION_DRIVER=file in .env\n";
echo "   3. Run: php artisan cache:clear && php artisan config:clear\n";
echo "   4. Check storage/framework/sessions has proper permissions (775)\n";
echo "   5. If issue persists, try: php artisan session:table && php artisan migrate (use database session)\n";
