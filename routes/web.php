<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SawController;
use App\Http\Controllers\HasilAlokasiController;
use App\Http\Controllers\WaitingListController;
use App\Http\Controllers\AdminSiswaController;
use App\Http\Controllers\AllocationExportController;
use App\Http\Controllers\SiswaSeederController;

use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return redirect('/login');
})->middleware('guest');

Route::get('/debug-hasil-seleksi', function () {
    echo "<h2>Debug Hasil Seleksi Waitlist</h2>";

    // Count alokasi
    $totalDiterima = \App\Models\Alokasi::where('status', 'diterima')->count();
    $totalWaitlist = \App\Models\Alokasi::where('status', 'waitlist')->count();
    $totalSiswa = \App\Models\Siswa::count();

    echo "Total Siswa: $totalSiswa<br>";
    echo "Total Diterima: $totalDiterima<br>";
    echo "Total Waitlist: $totalWaitlist<br>";
    echo "Total Alokasi: " . ($totalDiterima + $totalWaitlist) . "<br><br>";

    // Query sama seperti di controller - untuk diterima
    $query_diterima = \App\Models\Siswa::leftJoin('alokasis', 'siswas.id', '=', 'alokasis.siswa_id')
        ->leftJoin('peminatans', 'alokasis.peminatan_id', '=', 'peminatans.id')
        ->select('siswas.*', 'alokasis.id as alokasi_id', 'alokasis.skor_saw', 'alokasis.status', 'peminatans.nama as peminatan_nama')
        ->whereNotNull('alokasis.id');

    echo "Query Diterima count: " . $query_diterima->count() . "<br>";

    // Query sama seperti di controller - untuk waitlist
    $query_waitlist = \App\Models\Siswa::leftJoin('alokasis', 'siswas.id', '=', 'alokasis.siswa_id')
        ->leftJoin('peminatans', 'alokasis.peminatan_id', '=', 'peminatans.id')
        ->select('siswas.*', 'alokasis.id as alokasi_id', 'alokasis.skor_saw', 'alokasis.status', 'peminatans.nama as peminatan_nama')
        ->whereNull('alokasis.id');

    echo "Query Waitlist count: " . $query_waitlist->count() . "<br><br>";

    // Show first 5 waitlist
    echo "<strong>First 5 Waitlist Siswa:</strong><br>";
    $waitlist = $query_waitlist->orderBy('siswas.nis')->limit(5)->get();
    foreach ($waitlist as $w) {
        echo "- {$w->nis} ({$w->nama}): alokasi_id={$w->alokasi_id}<br>";
    }

    dd("Debug complete");
});


Route::middleware('auth')->get('/dashboard', function () {
    return match (auth()->user()->role) {
        'admin' => redirect(route('admin.dashboard')),
        'guru_bk' => redirect(route('guru.dashboard')),
        'siswa' => redirect(route('siswa.dashboard')),
        default => abort(403),
    };
})->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard', [
            'totalSiswa' => \App\Models\Siswa::count(),
            'siswaLengkap' => \App\Models\Siswa::where('nilai_matematika', '!=', null)
                ->where('nilai_fisika', '!=', null)
                ->where('nilai_kimia', '!=', null)
                ->where('nilai_biologi', '!=', null)
                ->where('nilai_tik', '!=', null)
                ->where('nilai_binggris', '!=', null)
                ->where('nilai_sosiologi', '!=', null)
                ->where('nilai_ekonomi', '!=', null)
                ->where('nilai_geografi', '!=', null)
                ->where('pilihan_peminatan_1', '!=', null)
                ->where('pilihan_peminatan_2', '!=', null)
                ->where('pilihan_peminatan_3', '!=', null)
                ->count(),
            'totalPeminatan' => \App\Models\Peminatan::count(),
            'totalKriteria' => \App\Models\Kriteria::count(),
        ]);
    })->name('admin.dashboard');

    // Admin Routes
    Route::resource('admin/peminatan', \App\Http\Controllers\PeminatanController::class)->names('admin.peminatan');
    Route::resource('admin/kriteria', \App\Http\Controllers\KriteriaController::class)->names('admin.kriteria');
    Route::get('/admin/reset-password-siswa', fn() => view('admin.reset-password-siswa.index'))->name('reset-password-siswa.index');

    // Admin Siswa Monitoring Routes
    Route::get('/admin/siswa/profil', [AdminSiswaController::class, 'profilSiswa'])->name('admin.siswa.profil');
    Route::get('/admin/siswa/{id}/show', [AdminSiswaController::class, 'showSiswa'])->name('admin.siswa.show');
    Route::get('/admin/siswa/{id}/edit', [AdminSiswaController::class, 'editSiswa'])->name('admin.siswa.edit');
    Route::post('/admin/siswa/{id}/update', [AdminSiswaController::class, 'updateSiswa'])->name('admin.siswa.update');
    Route::post('/admin/siswa/{id}/delete', [AdminSiswaController::class, 'deleteSiswa'])->name('admin.siswa.delete');
    Route::get('/admin/siswa/input-nilai', [AdminSiswaController::class, 'inputNilai'])->name('admin.siswa.input-nilai');
    Route::get('/admin/siswa/input-nilai/{id}/show', [AdminSiswaController::class, 'showNilai'])->name('admin.siswa.input-nilai.show');
    Route::get('/admin/siswa/input-nilai/{id}/edit', [AdminSiswaController::class, 'editNilai'])->name('admin.siswa.input-nilai.edit');
    Route::post('/admin/siswa/input-nilai/{id}/update', [AdminSiswaController::class, 'updateNilai'])->name('admin.siswa.input-nilai.update');
    Route::post('/admin/siswa/input-nilai/{id}/delete', [AdminSiswaController::class, 'deleteNilai'])->name('admin.siswa.input-nilai.delete');
    Route::get('/admin/siswa/pilih-peminatan', [AdminSiswaController::class, 'pilihPeminatan'])->name('admin.siswa.pilih-peminatan');
    Route::get('/admin/siswa/pilih-peminatan/{id}/show', [AdminSiswaController::class, 'showPilihanPeminatan'])->name('admin.siswa.pilih-peminatan.show');
    Route::get('/admin/siswa/pilih-peminatan/{id}/edit', [AdminSiswaController::class, 'editPilihanPeminatan'])->name('admin.siswa.pilih-peminatan.edit');
    Route::post('/admin/siswa/pilih-peminatan/{id}/update', [AdminSiswaController::class, 'updatePilihanPeminatan'])->name('admin.siswa.pilih-peminatan.update');
    Route::get('/admin/siswa/hasil-seleksi', [AdminSiswaController::class, 'hasilSeleksi'])->name('admin.siswa.hasil-seleksi');
    Route::get('/admin/siswa/hasil-seleksi/{id}/show', [AdminSiswaController::class, 'showHasilSeleksi'])->name('admin.siswa.hasil-seleksi.show');
    Route::get('/admin/siswa/hasil-seleksi/edit/{siswaId}', [AdminSiswaController::class, 'editAlokasi'])->name('admin.siswa.hasil-seleksi.edit-alokasi');
    Route::post('/admin/siswa/hasil-seleksi/store/{siswaId}', [AdminSiswaController::class, 'storeAlokasi'])->name('admin.siswa.hasil-seleksi.store-alokasi');
    Route::get('/admin/siswa/belum-diterima', [AdminSiswaController::class, 'siswaBelumditerima'])->name('admin.siswa.belum-diterima');
    Route::post('/admin/siswa/simpan-alokasi-manual', [AdminSiswaController::class, 'simpanAlokasiManual'])->name('admin.siswa.simpan-alokasi-manual');
    Route::post('/admin/siswa/allocate-all-waitlist', [AdminSiswaController::class, 'allocateAllWaitlist'])->name('admin.siswa.allocate-all-waitlist');
    Route::get('/admin/siswa/skor-saw', [AdminSiswaController::class, 'skorSaw'])->name('admin.siswa.skor-saw');
    Route::get('/admin/siswa/skor-saw/{id}/show', [AdminSiswaController::class, 'showSkorSaw'])->name('admin.siswa.skor-saw.show');
    Route::get('/admin/siswa/{id}/raport', [AdminSiswaController::class, 'downloadRaport'])->name('admin.siswa.raport');

    // Siswa Seeder Generator
    Route::get('/siswa-seeder/form', [SiswaSeederController::class, 'form'])->name('siswa-seeder.form');
    Route::post('/siswa-seeder/generate', [SiswaSeederController::class, 'generate'])->name('siswa-seeder.generate');
});

// BK Routes - bisa diakses oleh admin dan guru_bk
Route::middleware(['auth', 'role:admin,guru_bk'])->group(function () {
    // Admin dan Guru BK dapat mengakses fitur BK
    Route::get('/guru/jalankan-saw', [SawController::class, 'index'])->name('guru.jalankan-saw.index');
    Route::post('/guru/jalankan-saw', [SawController::class, 'jalankan'])->name('guru.jalankan-saw.proses');
    Route::get('/guru/hasil-alokasi', [HasilAlokasiController::class, 'index'])->name('guru.hasil-alokasi.index');
    Route::get('/guru/hasil-alokasi/export', [HasilAlokasiController::class, 'export'])->name('guru.hasil-alokasi.export');
    Route::get('/guru/hasil-alokasi/export-excel', [AllocationExportController::class, 'exportExcel'])->name('guru.hasil-alokasi.export-excel');
    Route::get('/guru/waitinglist', [WaitingListController::class, 'index'])->name('guru.waitinglist.index');
    Route::get('/guru/waitinglist/export', [WaitingListController::class, 'export'])->name('guru.waitinglist.export');
});

Route::middleware(['auth', 'role:guru_bk'])->group(function () {
    Route::get('/guru/dashboard', fn() => view('guru.dashboard'))->name('guru.dashboard');
});


Route::middleware(['auth', 'role:siswa,admin'])->group(function () {
    Route::get('/siswa/dashboard', function () {
        // Redirect admin ke admin dashboard
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('siswa.dashboard');
    })->name('siswa.dashboard');

    // Siswa Routes - bisa diakses oleh siswa dan admin
    Route::get('/siswa/input-nilai-raport', [SiswaController::class, 'showInputNilai'])
        ->name('siswa.input-nilai-raport.index');
    Route::post('/siswa/input-nilai-raport', [SiswaController::class, 'updateNilai'])
        ->name('siswa.input-nilai-raport.store');
    Route::get('/siswa/pilih-peminatan', [SiswaController::class, 'showPilihPeminatan'])
        ->name('siswa.pilih-peminatan.index');
    Route::post('/siswa/pilih-peminatan', [SiswaController::class, 'simpanPilihan'])
        ->name('siswa.pilih-peminatan.store');
    Route::get('/siswa/hasil-seleksi', [SiswaController::class, 'hasilSeleksi'])
        ->name('siswa.hasil-seleksi.index');
    Route::get('/siswa/skor-saw', [SiswaController::class, 'skorSaw'])
        ->name('siswa.skor-saw.index');
    Route::get('/siswa/ubah-password', fn() => view('siswa.ubah-password.edit'))
        ->name('siswa.ubah-password.edit');
    Route::get('/siswa/profile', [SiswaController::class, 'showProfile'])->name('siswa.profile');
    Route::put('/siswa/profile', [SiswaController::class, 'updateProfile'])->name('siswa.profile.update');
});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
