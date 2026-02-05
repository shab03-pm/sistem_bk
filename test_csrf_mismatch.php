<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "╔════════════════════════════════════════════════════════╗\n";
echo "║     MIDDLEWARE & CSRF TOKEN GENERATION TEST           ║\n";
echo "╚════════════════════════════════════════════════════════╝\n\n";

// Create a mock GET request to /register
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

echo "1️⃣ Simulating GET /register:\n\n";

// Start session for the GET request
Session::start();
$getSessionId = session_id();
echo "   Session ID created: " . substr($getSessionId, 0, 20) . "...\n";

// Generate CSRF token
$token = csrf_token();
echo "   CSRF Token generated: " . substr($token, 0, 30) . "...\n";

// Check session contents
$sessionData = $_SESSION;
echo "   Session data keys: " . implode(', ', array_keys($sessionData)) . "\n";
echo "   CSRF_TOKEN in session: " . (isset($sessionData['CSRF_TOKEN']) ? '✅' : '❌') . "\n\n";

echo "2️⃣ When form is submitted (POST /register):\n\n";

echo "   Browser sends:\n";
echo "     - Cookie: sistem-bk-session=$getSessionId\n";
echo "     - Body: _token=$token\n\n";

echo "   Laravel middleware:\n";
echo "     1. Reads session ID from cookie\n";
echo "     2. Loads session from database\n";
echo "     3. Gets CSRF_TOKEN from session\n";
echo "     4. Gets _token from POST body\n";
echo "     5. Compares them\n\n";

echo "3️⃣ Possible Mismatch Scenarios:\n\n";

echo "   ❌ Scenario A: Session not in database\n";
echo "     - Cause: GET /register didn't save session to DB\n";
echo "     - Fix: Ensure SessionMiddleware runs and saves\n\n";

echo "   ❌ Scenario B: Cookie not sent with POST\n";
echo "     - Cause: Browser cookies disabled or SameSite issue\n";
echo "     - Fix: Check browser privacy settings\n\n";

echo "   ❌ Scenario C: Token regenerated between requests\n";
echo "     - Cause: Session ID changed\n";
echo "     - Fix: Don't regenerate until AFTER POST succeeds\n\n";

echo "4️⃣ What Laravel 11 Expects:\n";
echo "   - VerifyCsrfToken middleware enabled\n";
echo "   - SessionMiddleware runs before CSRF check\n";
echo "   - GET /register creates session\n";
echo "   - POST /register receives same session\n";
echo "   - CSRF token from request matches session token\n\n";

echo "5️⃣ Fix to Try:\n";
echo "   Add to RegisteredUserController::create():\n";
echo "     \$request->session()->regenerate();\n";
echo "   This ensures session is created on GET request\n";
