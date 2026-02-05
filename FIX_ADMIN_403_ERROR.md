# Fix untuk Admin Login 403 Forbidden Error

## Problem Identification

**Root Cause:** ID collision antara tabel `users` dan `siswas`

- Admin user memiliki ID 1 di tabel `users`
- Alfina (siswa) juga memiliki ID 1 di tabel `siswas`
- Ketika admin login dan session disimpan, Laravel menyimpan user ID (1)
- Pada request berikutnya, Laravel memanggil `retrieveById(1)` untuk restore session
- Sebelumnya, `MultiModelUserProvider` mencari Siswa DULU, jadi menemukan Alfina (ID 1)
- Alfina adalah siswa (bukan admin), jadi middleware `role:admin` reject dengan 403

## Solution Implemented

### 1. Update `MultiModelUserProvider` (app/Auth/MultiModelUserProvider.php)

Mengubah urutan pencarian saat restore session:

- **Sebelumnya:** Cari Siswa dulu → kemudian User
- **Sekarang:** Gunakan session hint `auth_model_type` untuk tahu tabel mana yang harus dicari
    - Jika session menyimpan 'siswa' → cari Siswa terlebih dahulu
    - Jika session menyimpan 'user' → cari User terlebih dahulu
    - Fallback ke pencarian model lainnya jika tidak ditemukan

**Keuntungan:**

- Resolves ID collision issues
- Session will always restore the correct user model
- Backward compatible dengan logic yang ada

### 2. Update `AuthenticatedSessionController` (app/Http/Controllers/Auth/AuthenticatedSessionController.php)

Menambahkan session storage saat login:

```php
// Setelah successful login
$request->session()->put('auth_model_type', 'user');  // untuk admin/guru
// atau
$request->session()->put('auth_model_type', 'siswa'); // untuk siswa
```

Menambahkan session cleanup saat logout:

```php
$request->session()->forget('auth_model_type');
```

### 3. Update `ResolveAuthenticatedSiswa` Middleware

Middleware ini juga sekarang menyimpan `auth_model_type` session hint untuk consistency.

## Testing

Hasil test menunjukkan:

- ✅ Admin login berhasil
- ✅ Session model type disimpan dengan benar ('user' untuk admin)
- ✅ Pada page reload, admin user di-restore dengan benar (bukan Alfina)
- ✅ Middleware `role:admin` akan PASS (tidak 403)

## Langkah-langkah untuk Testing

1. **Login sebagai Admin:**
    - Email: `admin@sistem.com`
    - Password: `password`

2. **Expected Result:**
    - Login berhasil
    - Redirect ke `/admin/dashboard`
    - TIDAK ada error 403

3. **Verify Session:**
    - Session akan menyimpan `auth_model_type = 'user'`
    - Ini mencegah confusion antara User dan Siswa dengan ID sama

## Additional Notes

**ID Collision Issue:**

- Total 6 overlapping IDs antara User dan Siswa (4, 1, 2, 5, 6, 3)
- Ini terjadi karena kedua tabel menggunakan auto-increment dari ID 1
- Session hint approach memecahkan masalah tanpa perlu migrasi database

**Long-term Recommendation:**

- Pertimbangkan refactor untuk menggunakan single User table dengan role column
- Atau gunakan UUID untuk menghindari ID collision
- Saat ini fix ini sustainable dan tidak memerlukan database changes

## Files Modified

1. `app/Auth/MultiModelUserProvider.php` - Perubahan logika retrieveById()
2. `app/Http/Controllers/Auth/AuthenticatedSessionController.php` - Tambah session storage
3. `app/Http/Middleware/ResolveAuthenticatedSiswa.php` - Tambah session hint

## Files Created (untuk testing/debugging)

- `check_id_collision.php` - Check untuk ID collision
- `test_admin_fix.php` - Complete authentication flow test
- `test_admin_login_fix.php` - Provider-level test
