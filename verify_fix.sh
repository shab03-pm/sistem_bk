#!/bin/bash
# Quick verification script for admin login 403 fix

echo "=========================================="
echo "Admin Login 403 Fix - Verification"
echo "=========================================="
echo ""

# Check if all modified files exist and are readable
echo "1. Checking modified files..."
files=(
    "app/Auth/MultiModelUserProvider.php"
    "app/Http/Controllers/Auth/AuthenticatedSessionController.php"
    "app/Http/Middleware/ResolveAuthenticatedSiswa.php"
)

for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        echo "   ✅ $file"
    else
        echo "   ❌ $file (NOT FOUND)"
    fi
done

echo ""
echo "2. Verifying code changes..."

# Check MultiModelUserProvider
if grep -q "Session::get('auth_model_type')" app/Auth/MultiModelUserProvider.php; then
    echo "   ✅ MultiModelUserProvider updated"
else
    echo "   ❌ MultiModelUserProvider NOT updated"
fi

# Check AuthenticatedSessionController
if grep -q "auth_model_type" app/Http/Controllers/Auth/AuthenticatedSessionController.php; then
    echo "   ✅ AuthenticatedSessionController updated"
else
    echo "   ❌ AuthenticatedSessionController NOT updated"
fi

# Check ResolveAuthenticatedSiswa
if grep -q "auth_model_type" app/Http/Middleware/ResolveAuthenticatedSiswa.php; then
    echo "   ✅ ResolveAuthenticatedSiswa updated"
else
    echo "   ❌ ResolveAuthenticatedSiswa NOT updated"
fi

echo ""
echo "3. Running comprehensive test..."
php test_comprehensive_fix.php

echo ""
echo "=========================================="
echo "Verification Complete!"
echo "=========================================="
