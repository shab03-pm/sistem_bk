<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Siswa;
use App\Models\Alokasi;
use App\Models\Peminatan;
use App\Models\Kriteria;

class AllocationSystem3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'allocation:system3';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Allocation System 3: Process each pilihan separately by score, then waitlist with highest score from available pilihan';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Memulai alokasi System 3...');

        // Reset semua alokasi
        Alokasi::truncate();
        $this->info('✓ Reset semua alokasi');

        // Reset kuota peminatan
        foreach (Peminatan::all() as $peminatan) {
            $peminatan->update(['kuota' => $peminatan->kuota_maksimal]);
        }
        $this->info('✓ Reset kuota peminatan');

        $siswas = Siswa::with('pilihanPeminatan1', 'pilihanPeminatan2', 'pilihanPeminatan3')
            ->orderBy('id')
            ->get();

        $totalSiswa = $siswas->count();
        $diterima = 0;
        $waitlist = 0;

        $this->info("\n📊 Total siswa: {$totalSiswa}");

        // ===== STEP 1: PILIHAN 1 =====
        $this->line("\n📋 STEP 1: Processing Pilihan 1");
        $siswasP1 = $siswas->filter(fn($s) => $s->pilihan_peminatan_1)->values();

        // Pre-compute skor P1 dan sort
        $skorP1 = [];
        foreach ($siswasP1 as $siswa) {
            $skorP1[$siswa->id] = $siswa->pilihan_peminatan_1 ? $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_1) : 0;
        }

        $siswasP1Sorted = $siswasP1->sortByDesc(function ($siswa) use ($skorP1) {
            return $skorP1[$siswa->id];
        })->values();

        $siswasNotAllocatedP1 = [];

        foreach ($siswasP1Sorted as $siswa) {
            $skor = $skorP1[$siswa->id];
            $peminatan = Peminatan::find($siswa->pilihan_peminatan_1);

            if ($peminatan && $peminatan->sisaKursi() > 0) {
                // DITERIMA di Pilihan 1
                $skor_p2 = $siswa->pilihan_peminatan_2 ? $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_2) : 0;
                $skor_p3 = $siswa->pilihan_peminatan_3 ? $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_3) : 0;

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
                // Tidak diterima P1, lanjut ke P2
                $siswasNotAllocatedP1[] = $siswa;
            }
        }
        $this->line("  ✓ Pilihan 1: $diterima diterima");

        // ===== STEP 2: PILIHAN 2 =====
        $this->line("\n📋 STEP 2: Processing Pilihan 2 (dari siswa yang tidak diterima P1)");
        $siswasP2 = collect($siswasNotAllocatedP1)->filter(fn($s) => $s->pilihan_peminatan_2)->values();

        // Pre-compute skor P2 dan sort
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
                // DITERIMA di Pilihan 2
                $skor_p3 = $siswa->pilihan_peminatan_3 ? $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_3) : 0;

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
                // Tidak diterima P2, lanjut ke P3
                $siswasNotAllocatedP2[] = $siswa;
            }
        }
        $this->line("  ✓ Pilihan 2: " . ($diterima - $diterimaBefore) . " diterima");

        // ===== STEP 3: PILIHAN 3 =====
        $this->line("\n📋 STEP 3: Processing Pilihan 3 (dari siswa yang tidak diterima P1 & P2)");
        $siswasP3 = collect($siswasNotAllocatedP2)->filter(fn($s) => $s->pilihan_peminatan_3)->values();

        // Pre-compute skor P3 dan sort
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
                // DITERIMA di Pilihan 3
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
                // Tidak diterima P3, ke waitlist
                $siswasWaitlist[] = [
                    'siswa' => $siswa,
                    'skor_p1' => $skorP1[$siswa->id] ?? 0,
                    'skor_p2' => $skorP2[$siswa->id] ?? 0,
                    'skor_p3' => $skor
                ];
            }
        }
        $this->line("  ✓ Pilihan 3: " . ($diterima - $diterimaBefore) . " diterima");

        // ===== STEP 4: WAITLIST =====
        $this->line("\n📋 STEP 4: Processing Waitlist (cari peminatan dengan sisa kursi tertinggi)");

        foreach ($siswasWaitlist as $item) {
            $siswa = $item['siswa'];
            $scores = [
                1 => $item['skor_p1'],
                2 => $item['skor_p2'],
                3 => $item['skor_p3']
            ];

            // Cari pilihan dengan skor tertinggi
            arsort($scores);
            $pilihanTertinggi = key($scores);

            // Cari peminatan dari ketiga pilihan yang masih ada kursi
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

            // Jika ada peminatan dengan sisa kursi
            if (!empty($peminatanOptions)) {
                // Allocate ke peminatan dengan sisa kursi terbanyak
                arsort($peminatanOptions);
                $peminatanId = key($peminatanOptions);

                // Cari pilihan nomor berapa
                $pilihan = 1;
                if ($siswa->pilihan_peminatan_2 == $peminatanId)
                    $pilihan = 2;
                if ($siswa->pilihan_peminatan_3 == $peminatanId)
                    $pilihan = 3;

                // Skor yang disimpan = skor dari peminatan yang diallocate
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
                // Tidak ada peminatan dengan sisa kursi, cek semua peminatan
                $allPeminatanOptions = [];
                foreach (Peminatan::all() as $p) {
                    if ($p->sisaKursi() > 0) {
                        $allPeminatanOptions[$p->id] = $p->sisaKursi();
                    }
                }

                if (!empty($allPeminatanOptions)) {
                    // Allocate ke peminatan terbaik yang masih ada kursi
                    arsort($allPeminatanOptions);
                    $peminatanId = key($allPeminatanOptions);

                    // Gunakan skor tertinggi dari ketiga pilihan
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
        $this->line("  ✓ Waitlist: $waitlist ditambahkan");

        $this->info("\n✅ Alokasi selesai!");
        $this->info("📊 Hasil:");
        $this->info("   • Diterima: $diterima");
        $this->info("   • Waitlist: $waitlist");

        return Command::SUCCESS;
    }

    /**
     * Hitung skor SAW untuk siswa terhadap peminatan tertentu
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
                $maxNilai = 100;
            }

            $normalisasi = $nilai / $maxNilai;
            $totalSkor += $kriteria->bobot * $normalisasi;
        }

        return round($totalSkor, 4);
    }
}
