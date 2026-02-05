<?php

namespace App\Http\Controllers;

use App\Models\Alokasi;
use App\Models\Siswa; // ✅ GUNAKAN MODEL SISWA
use App\Models\Peminatan;
use App\Exports\System3AllocationExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class HasilAlokasiController extends Controller
{
    public function index(Request $request)
    {
        // Debug: Cek data alokasi
        $testAlokasi = Alokasi::with('siswa')->first();
        if ($testAlokasi) {
            \Log::info('Debug Alokasi:', [
                'alokasi_id' => $testAlokasi->id,
                'siswa_id' => $testAlokasi->siswa_id,
                'siswa_exists' => $testAlokasi->siswa ? 'Yes' : 'No',
                'siswa_data' => $testAlokasi->siswa
            ]);
        }

        $query = Alokasi::with([
            'siswa', // ✅ Cukup load 'siswa' saja
            'peminatan'
        ])->where('status', 'diterima')  // ✅ HANYA TAMPILKAN YANG DITERIMA
            ->orderBy('skor_saw', 'desc');

        // Filter berdasarkan peminatan
        if ($request->filled('peminatan_id')) {
            $query->where('peminatan_id', $request->peminatan_id);
        }

        // Filter berdasarkan kelas asal
        if ($request->filled('kelas_asal')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_asal', $request->kelas_asal);
            });
        }

        // Filter berdasarkan pencarian nama/NIS
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%") // ✅ GUNAKAN 'nama' bukan 'name'
                    ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        $alokasis = $query->paginate(15);
        $peminatans = Peminatan::all();

        // ✅ AMBIL KELAS DARI TABEL SISWAS, BUKAN USERS
        $kelasList = Siswa::whereNotNull('kelas_asal')
            ->distinct()
            ->pluck('kelas_asal')
            ->filter()
            ->values();

        // Statistik - ✅ HITUNG DARI TABEL ALOKASIS BERDASARKAN STATUS
        $totalDiterima = Alokasi::where('status', 'diterima')->count();
        $totalWaitlist = Alokasi::where('status', 'waitlist')->count();
        $totalSiswa = Siswa::count(); // ✅ GUNAKAN MODEL SISWA
        $belumDiterima = $totalWaitlist;  // Belum diterima = waitlist

        return view('guru.hasil-alokasi.index', compact(
            'alokasis',
            'peminatans',
            'totalDiterima',
            'belumDiterima',
            'totalSiswa',
            'kelasList'
        ));
    }

    public function export()
    {
        return Excel::download(new System3AllocationExport(), 'hasil_alokasi_saw_' . date('Y-m-d') . '.xlsx');
    }
}