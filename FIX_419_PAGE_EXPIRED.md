# Fix untuk 419 Page Expired Error

## Problem

Error **419 Page Expired** muncul saat user mencoba submit form atau melakukan action yang memerlukan CSRF token.

## Root Cause

Missing `$request->session()->regenerate()` setelah user login/register dalam `RegisteredUserController`.

Tanpa session regeneration:

- Session cookie mungkin tidak ter-update dengan benar
- CSRF token dari form tidak match dengan session baru
- Laravel reject request dengan 419 (CSRF token mismatch)

## Solution

Menambahkan `$request->session()->regenerate()` setelah `Auth::login()` di `RegisteredUserController`.

### File Modified

**[app/Http/Controllers/Auth/RegisteredUserController.php](app/Http/Controllers/Auth/RegisteredUserController.php)**

```php
Auth::login($user);
$request->session()->regenerate();  // ✅ Added this line
$request->session()->put('auth_model_type', 'siswa');
```

### Why This Works

1. `Auth::login()` - Authenticate user
2. `session()->regenerate()` - Create NEW session ID to prevent session fixation attacks
3. New CSRF token is generated and synced with new session ID
4. Next request: Token validation passes ✅

## Session Configuration

```
Driver: file
Lifetime: 1440 minutes
Path: /storage/framework/sessions
Cookie: sistem-bk-session
Secure: No (localhost)
HttpOnly: Yes (secure)
```

## Testing

User dapat sekarang:
✅ Register dengan form
✅ Auto-login setelah register
✅ Redirect ke dashboard (tanpa 419 error)
✅ Session valid untuk request berikutnya

## Note

- `AuthenticatedSessionController` sudah memiliki session regeneration yang benar
- Hanya `RegisteredUserController` yang missing ini
- Fix ini juga mempertahankan ID collision resolution (session hint)
