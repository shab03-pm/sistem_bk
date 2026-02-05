<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Http\Request;

echo "=== SESSION TEST ===\n\n";

// Create a fake request
$request = new Request();

echo "1️⃣ Session config:\n";
echo "   Driver: " . config('session.driver') . "\n";
echo "   Path: " . config('session.files') . "\n";
echo "   Lifetime: " . config('session.lifetime') . " minutes\n";

echo "\n2️⃣ Session storage test:\n";
$sessionPath = storage_path('framework/sessions');
if (is_writable($sessionPath)) {
    echo "   ✅ Session dir writable\n";
} else {
    echo "   ❌ Session dir NOT writable\n";
}

echo "\n3️⃣ Test CSRF middleware:\n";
// Create instance of CSRF middleware
$middleware = app(\App\Http\Middleware\VerifyCsrfToken::class);
echo "   CSRF Middleware exists: ✅\n";

echo "\n4️⃣ Check stored sessions:\n";
$files = glob($sessionPath . '/*');
$sessionFiles = array_filter($files, fn($f) => is_file($f) && basename($f) !== '.gitignore');
echo "   Total session files: " . count($sessionFiles) . "\n";
if (count($sessionFiles) > 0) {
    echo "   Latest sessions:\n";
    usort($sessionFiles, fn($a, $b) => filemtime($b) - filemtime($a));
    foreach (array_slice($sessionFiles, 0, 3) as $f) {
        $size = filesize($f);
        $time = date('Y-m-d H:i:s', filemtime($f));
        echo "     - " . basename($f) . " ({$size} bytes, {$time})\n";
    }
}
