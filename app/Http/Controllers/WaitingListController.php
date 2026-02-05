<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Alokasi;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class WaitingListController extends Controller
{
    public function index(Request $request)
    {
        // Query dari tabel ALOKASIS dengan status='waitlist'
        $query = Alokasi::where('status', 'waitlist')
            ->with(['siswa', 'peminatan']);

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        $waitingList = $query->paginate(15);

        // Statistik
        $totalSiswaLengkap = Siswa::whereNotNull('pilihan_peminatan_1')
            ->whereNotNull('nilai_matematika')
            ->count();

        $totalDiterima = Alokasi::where('status', 'diterima')->count();
        $totalWaiting = Alokasi::where('status', 'waitlist')->count();

        return view('guru.waitinglist.index', compact(
            'waitingList',
            'totalWaiting',
            'totalSiswaLengkap',
            'totalDiterima'
        ));
    }

    public function export()
    {
        $waitingList = Alokasi::where('status', 'waitlist')
            ->with(['siswa', 'peminatan'])
            ->get();

        $filename = 'waitinglist-siswa-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($waitingList) {
            $file = fopen('php://output', 'w');

            // Header CSV
            fputcsv($file, [
                'No',
                'NIS',
                'Nama Siswa',
                'Kelas Asal',
                'Pilihan 1',
                'Pilihan 2',
                'Pilihan 3',
                'Rata-rata Nilai'
            ]);

            // Data
            $no = 1;
            foreach ($waitingList as $siswa) {
                // Hitung rata-rata nilai
                $nilaiFields = [
                    'nilai_matematika',
                    'nilai_fisika',
                    'nilai_kimia',
                    'nilai_biologi',
                    'nilai_tik',
                    'nilai_binggris',
                    'nilai_sosiologi',
                    'nilai_ekonomi',
                    'nilai_geografi'
                ];

                $totalNilai = 0;
                $jumlahNilai = 0;
                foreach ($nilaiFields as $field) {
                    if ($siswa->{$field} !== null) {
                        $totalNilai += $siswa->{$field};
                        $jumlahNilai++;
                    }
                }
                $rataRata = $jumlahNilai > 0 ? round($totalNilai / $jumlahNilai, 2) : 0;

                fputcsv($file, [
                    $no++,
                    $siswa->nis ?? '-',
                    $siswa->nama ?? '-',
                    $siswa->kelas_asal ?? '-',
                    $siswa->pilihanPeminatan1?->nama ?? '-',
                    $siswa->pilihanPeminatan2?->nama ?? '-',
                    $siswa->pilihanPeminatan3?->nama ?? '-',
                    $rataRata
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Hitung skor SAW untuk siswa pada peminatan tertentu
     */
    private function hitungSkorSaw($siswa, $peminatanId)
    {
        $kriterias = Kriteria::where('peminatan_id', $peminatanId)->get();

        if ($kriterias->isEmpty()) {
            return 0;
        }

        $totalSkor = 0;
        foreach ($kriterias as $kriteria) {
            $nilai = $siswa->{'nilai_' . $kriteria->mapel} ?? 0;

            // Cari nilai maksimum dari SEMUA siswa
            $maxNilai = Siswa::whereNotNull('nilai_' . $kriteria->mapel)
                ->max('nilai_' . $kriteria->mapel);

            if ($maxNilai === null || $maxNilai == 0) {
                $maxNilai = 100; // fallback
            }

            $normalisasi = $nilai / $maxNilai;
            $totalSkor += $kriteria->bobot * $normalisasi;
        }

        return round($totalSkor, 4);
    }
}