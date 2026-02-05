#!/bin/bash

echo "=== TESTING LOGIN ROUTE ==="
echo ""

# Kill any existing Laravel server
pkill -f "php artisan serve" 2>/dev/null || true
sleep 1

# Start Laravel server in background
cd /d/sistem-bk2/sistem-bk
php artisan serve --port=8000 &
SERVER_PID=$!
sleep 3

echo "Server started (PID: $SERVER_PID)"
echo ""

# Test login route
echo "1️⃣ Testing login page..."
curl -s http://localhost:8000/login | grep -q "login" && echo "✅ Login page accessible" || echo "❌ Login page failed"

echo ""
echo "2️⃣ Attempting login with Siswa credentials..."

# Do login POST request
RESPONSE=$(curl -s -c /tmp/cookies.txt -b /tmp/cookies.txt \
  -X POST http://localhost:8000/login \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "login=alfina.nurul.aprilliyani.10004@siswa.sekolah.id&password=siswa123456" \
  -w "\n%{http_code}" | tail -1)

HTTP_CODE=$RESPONSE
echo "HTTP Status: $HTTP_CODE"

if [ "$HTTP_CODE" = "302" ]; then
  echo "✅ Login succeeded (redirect)"
  
  echo ""
  echo "3️⃣ Following redirect to dashboard..."
  curl -s -b /tmp/cookies.txt http://localhost:8000/siswa/dashboard | grep -q "siswa" && echo "✅ Siswa dashboard accessible" || echo "⚠️  Check browser"
else
  echo "❌ Login failed with HTTP $HTTP_CODE"
fi

echo ""
echo "Testing complete. Server still running on http://localhost:8000"
echo "Kill with: kill $SERVER_PID"
