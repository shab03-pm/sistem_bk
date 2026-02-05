<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Peminatan;
use App\Models\Alokasi;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SawController extends Controller
{
    public function index()
    {
        // Hitung statistik - ✅ GUNAKAN MODEL SISWA
        $siswaLengkap = Siswa::whereNotNull('pilihan_peminatan_1')
            ->whereNotNull('nilai_matematika')
            ->count();

        $totalPeminatan = Peminatan::count();
        $peminatanLengkap = Peminatan::has('kriterias')->count();

        $siapJalankan = ($siswaLengkap > 0 && $peminatanLengkap == $totalPeminatan && $totalPeminatan > 0);
        $status = $siapJalankan ? 'Siap' : 'Belum Siap';

        return view('guru.jalankan-saw.index', compact(
            'siswaLengkap',
            'totalPeminatan',
            'peminatanLengkap',
            'status',
            'siapJalankan'
        ));
    }

    public function jalankan(Request $request)
    {
        try {
            Log::info('Memulai proses SAW (System 3)...');

            // ✅ HAPUS HASIL ALOKASI SEBELUMNYA
            $deletedCount = Alokasi::count();
            Alokasi::truncate();
            Log::info("Hasil alokasi sebelumnya dihapus: {$deletedCount} record");

            // Reset kuota peminatan
            foreach (Peminatan::all() as $peminatan) {
                $peminatan->update(['kuota' => $peminatan->kuota_maksimal]);
            }
            Log::info("✓ Reset kuota peminatan");

            $siswas = Siswa::with('pilihanPeminatan1', 'pilihanPeminatan2', 'pilihanPeminatan3')
                ->orderBy('id')
                ->get();

            $totalSiswa = $siswas->count();
            $diterima = 0;
            $waitlist = 0;

            Log::info("Total siswa: {$totalSiswa}");

            // ===== STEP 1: PILIHAN 1 =====
            Log::info("STEP 1: Processing Pilihan 1");
            $siswasP1 = $siswas->filter(fn($s) => $s->pilihan_peminatan_1)->values();

            $skorP1 = [];
            foreach ($siswasP1 as $siswa) {
                $skorP1[$siswa->id] = $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_1);
            }

            $siswasP1Sorted = $siswasP1->sortByDesc(function ($siswa) use ($skorP1) {
                return $skorP1[$siswa->id];
            })->values();

            $siswasNotAllocatedP1 = [];

            foreach ($siswasP1Sorted as $siswa) {
                $skor = $skorP1[$siswa->id];
                $peminatan = Peminatan::find($siswa->pilihan_peminatan_1);

                if ($peminatan && $peminatan->sisaKursi() > 0) {
                    // Hitung skor untuk semua pilihan jika belum dihitung
                    $skor_p2 = isset($skorP2[$siswa->id]) ? $skorP2[$siswa->id] : ($siswa->pilihan_peminatan_2 ? $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_2) : 0);
                    $skor_p3 = isset($skorP3[$siswa->id]) ? $skorP3[$siswa->id] : ($siswa->pilihan_peminatan_3 ? $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_3) : 0);

                    Alokasi::create([
                        'siswa_id' => $siswa->id,
                        'peminatan_id' => $siswa->pilihan_peminatan_1,
                        'skor_saw' => $skor,
                        'skor_pilihan_1' => $skor,
                        'skor_pilihan_2' => $skor_p2,
                        'skor_pilihan_3' => $skor_p3,
                        'status' => 'diterima'
                    ]);
                    Peminatan::where('id', $siswa->pilihan_peminatan_1)->decrement('kuota', 1);
                    $diterima++;
                } else {
                    $siswasNotAllocatedP1[] = $siswa;
                }
            }
            Log::info("Pilihan 1: $diterima diterima");

            // ===== STEP 2: PILIHAN 2 =====
            Log::info("STEP 2: Processing Pilihan 2");
            $siswasP2 = collect($siswasNotAllocatedP1)->filter(fn($s) => $s->pilihan_peminatan_2)->values();

            $skorP2 = [];
            foreach ($siswasP2 as $siswa) {
                $skorP2[$siswa->id] = $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_2);
            }

            $siswasP2Sorted = $siswasP2->sortByDesc(function ($siswa) use ($skorP2) {
                return $skorP2[$siswa->id];
            })->values();

            $siswasNotAllocatedP2 = [];
            $diterimaBefore = $diterima;

            foreach ($siswasP2Sorted as $siswa) {
                $skor = $skorP2[$siswa->id];
                $peminatan = Peminatan::find($siswa->pilihan_peminatan_2);

                if ($peminatan && $peminatan->sisaKursi() > 0) {
                    // Hitung skor P3 jika belum ada
                    $skor_p3 = isset($skorP3[$siswa->id]) ? $skorP3[$siswa->id] : ($siswa->pilihan_peminatan_3 ? $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_3) : 0);

                    Alokasi::create([
                        'siswa_id' => $siswa->id,
                        'peminatan_id' => $siswa->pilihan_peminatan_2,
                        'skor_saw' => $skor,
                        'skor_pilihan_1' => $skorP1[$siswa->id] ?? 0,
                        'skor_pilihan_2' => $skor,
                        'skor_pilihan_3' => $skor_p3,
                        'status' => 'diterima'
                    ]);
                    Peminatan::where('id', $siswa->pilihan_peminatan_2)->decrement('kuota', 1);
                    $diterima++;
                } else {
                    $siswasNotAllocatedP2[] = $siswa;
                }
            }
            Log::info("Pilihan 2: " . ($diterima - $diterimaBefore) . " diterima");

            // ===== STEP 3: PILIHAN 3 =====
            Log::info("STEP 3: Processing Pilihan 3");
            $siswasP3 = collect($siswasNotAllocatedP2)->filter(fn($s) => $s->pilihan_peminatan_3)->values();

            $skorP3 = [];
            foreach ($siswasP3 as $siswa) {
                $skorP3[$siswa->id] = $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_3);
            }

            $siswasP3Sorted = $siswasP3->sortByDesc(function ($siswa) use ($skorP3) {
                return $skorP3[$siswa->id];
            })->values();

            $siswasWaitlist = [];
            $diterimaBefore = $diterima;

            foreach ($siswasP3Sorted as $siswa) {
                $skor = $skorP3[$siswa->id];
                $peminatan = Peminatan::find($siswa->pilihan_peminatan_3);

                if ($peminatan && $peminatan->sisaKursi() > 0) {
                    Alokasi::create([
                        'siswa_id' => $siswa->id,
                        'peminatan_id' => $siswa->pilihan_peminatan_3,
                        'skor_saw' => $skor,
                        'skor_pilihan_1' => $skorP1[$siswa->id] ?? 0,
                        'skor_pilihan_2' => $skorP2[$siswa->id] ?? 0,
                        'skor_pilihan_3' => $skor,
                        'status' => 'diterima'
                    ]);
                    Peminatan::where('id', $siswa->pilihan_peminatan_3)->decrement('kuota', 1);
                    $diterima++;
                } else {
                    $siswasWaitlist[] = [
                        'siswa' => $siswa,
                        'skor_p1' => $skorP1[$siswa->id] ?? 0,
                        'skor_p2' => $skorP2[$siswa->id] ?? 0,
                        'skor_p3' => $skor
                    ];
                }
            }
            Log::info("Pilihan 3: " . ($diterima - $diterimaBefore) . " diterima");

            // ===== STEP 4: WAITLIST =====
            Log::info("STEP 4: Processing Waitlist");
            foreach ($siswasWaitlist as $item) {
                $siswa = $item['siswa'];
                $scores = [
                    1 => $item['skor_p1'],
                    2 => $item['skor_p2'],
                    3 => $item['skor_p3']
                ];

                arsort($scores);
                $pilihanTertinggi = key($scores);

                $peminatanOptions = [];

                if ($siswa->pilihan_peminatan_1) {
                    $p = Peminatan::find($siswa->pilihan_peminatan_1);
                    if ($p && $p->sisaKursi() > 0) {
                        $peminatanOptions[$siswa->pilihan_peminatan_1] = $p->sisaKursi();
                    }
                }

                if ($siswa->pilihan_peminatan_2) {
                    $p = Peminatan::find($siswa->pilihan_peminatan_2);
                    if ($p && $p->sisaKursi() > 0) {
                        $peminatanOptions[$siswa->pilihan_peminatan_2] = $p->sisaKursi();
                    }
                }

                if ($siswa->pilihan_peminatan_3) {
                    $p = Peminatan::find($siswa->pilihan_peminatan_3);
                    if ($p && $p->sisaKursi() > 0) {
                        $peminatanOptions[$siswa->pilihan_peminatan_3] = $p->sisaKursi();
                    }
                }

                if (!empty($peminatanOptions)) {
                    arsort($peminatanOptions);
                    $peminatanId = key($peminatanOptions);

                    $pilihan = 1;
                    if ($siswa->pilihan_peminatan_2 == $peminatanId)
                        $pilihan = 2;
                    if ($siswa->pilihan_peminatan_3 == $peminatanId)
                        $pilihan = 3;

                    $skorToSave = match ($pilihan) {
                        1 => $item['skor_p1'],
                        2 => $item['skor_p2'],
                        3 => $item['skor_p3'],
                        default => 0
                    };

                    Alokasi::create([
                        'siswa_id' => $siswa->id,
                        'peminatan_id' => $peminatanId,
                        'skor_saw' => $skorToSave,
                        'skor_pilihan_1' => $item['skor_p1'],
                        'skor_pilihan_2' => $item['skor_p2'],
                        'skor_pilihan_3' => $item['skor_p3'],
                        'status' => 'waitlist'
                    ]);
                    Peminatan::where('id', $peminatanId)->decrement('kuota', 1);
                    $waitlist++;
                } else {
                    $allPeminatanOptions = [];
                    foreach (Peminatan::all() as $p) {
                        if ($p->sisaKursi() > 0) {
                            $allPeminatanOptions[$p->id] = $p->sisaKursi();
                        }
                    }

                    if (!empty($allPeminatanOptions)) {
                        arsort($allPeminatanOptions);
                        $peminatanId = key($allPeminatanOptions);
                        $skorToSave = max($item['skor_p1'], $item['skor_p2'], $item['skor_p3']);

                        Alokasi::create([
                            'siswa_id' => $siswa->id,
                            'peminatan_id' => $peminatanId,
                            'skor_saw' => $skorToSave,
                            'skor_pilihan_1' => $item['skor_p1'],
                            'skor_pilihan_2' => $item['skor_p2'],
                            'skor_pilihan_3' => $item['skor_p3'],
                            'status' => 'waitlist'
                        ]);
                        Peminatan::where('id', $peminatanId)->decrement('kuota', 1);
                        $waitlist++;
                    } else {
                        // Tidak ada peminatan dengan sisa kursi sama sekali, allocate ke pilihan dengan skor tertinggi
                        $skorTertinggi = 0;
                        $pilihanTertinggi = 1;
                        $peminatanTertinggi = $siswa->pilihan_peminatan_1;

                        if ($item['skor_p2'] > $skorTertinggi) {
                            $skorTertinggi = $item['skor_p2'];
                            $pilihanTertinggi = 2;
                            $peminatanTertinggi = $siswa->pilihan_peminatan_2;
                        }
                        if ($item['skor_p3'] > $skorTertinggi) {
                            $skorTertinggi = $item['skor_p3'];
                            $pilihanTertinggi = 3;
                            $peminatanTertinggi = $siswa->pilihan_peminatan_3;
                        }

                        Alokasi::create([
                            'siswa_id' => $siswa->id,
                            'peminatan_id' => $peminatanTertinggi,
                            'skor_saw' => $skorTertinggi,
                            'skor_pilihan_1' => $item['skor_p1'],
                            'skor_pilihan_2' => $item['skor_p2'],
                            'skor_pilihan_3' => $item['skor_p3'],
                            'status' => 'waitlist'
                        ]);
                        $waitlist++;
                    }
                }
            }
            Log::info("Waitlist: $waitlist ditambahkan");

            return redirect()->route('guru.hasil-alokasi.index')
                ->with('success', "Proses SAW (System 3) berhasil! Diterima: {$diterima}, Waitlist: {$waitlist}");

        } catch (\Exception $e) {
            Log::error('Error menjalankan SAW: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->with('error', 'Terjadi kesalahan saat menjalankan SAW: ' . $e->getMessage());
        }
    }

    /**
     * Hitung sisa kursi untuk peminatan
     */
    private function hitungSisaKursi($peminatanId)
    {
        $peminatan = Peminatan::find($peminatanId);
        if (!$peminatan) {
            return 0;
        }

        // Refresh model dari database untuk mendapatkan kuota terbaru
        $peminatan->refresh();

        // Gunakan column 'kuota' yang sudah tracking real-time
        return max(0, $peminatan->kuota);
    }

    // File: app/Http/Controllers/SawController.php
    private function hitungSkorSaw($siswa, $peminatanId)
    {
        $kriterias = Kriteria::where('peminatan_id', $peminatanId)->get();

        if ($kriterias->isEmpty()) {
            return 0;
        }

        $totalSkor = 0;
        foreach ($kriterias as $kriteria) {
            $nilai = $siswa->{'nilai_' . $kriteria->mapel} ?? 0;

            // Cari nilai maksimum dari SEMUA siswa (bukan hanya yang memilih peminatan ini)
            $maxNilai = Siswa::whereNotNull('nilai_' . $kriteria->mapel)
                ->max('nilai_' . $kriteria->mapel);

            if ($maxNilai === null || $maxNilai == 0) {
                $maxNilai = 100; // fallback
            }

            $normalisasi = $nilai / $maxNilai;
            $totalSkor += $kriteria->bobot * $normalisasi;
        }

        return $totalSkor; // Return nilai asli, jangan dibulatkan
    }
}