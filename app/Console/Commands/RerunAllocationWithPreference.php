<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Siswa;
use App\Models\Alokasi;
use App\Models\Peminatan;

class RerunAllocationWithPreference extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'allocation:rerun-with-preference';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Rerun allocation dengan sistem preferensi pilihan dan quota';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Memulai rerun alokasi dengan preferensi pilihan...');

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

        // ✅ Pre-compute skor dan sort siswa berdasarkan skor pilihan 1 (tertinggi dulu)
        $this->info('⏳ Pre-computing skor untuk semua siswa...');
        $skorCache = [];
        foreach ($siswas as $siswa) {
            $skorCache[$siswa->id] = $siswa->pilihan_peminatan_1 ? $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_1) : 0;
        }

        $siswas = $siswas->sortByDesc(function ($siswa) use ($skorCache) {
            return $skorCache[$siswa->id];
        })->values();

        $totalSiswa = $siswas->count();
        $diterima = 0;
        $waitlist = 0;
        $ditolak = 0;

        $this->info("\n📊 Total siswa: {$totalSiswa}");
        $this->info("✓ Siswa disort berdasarkan skor pilihan 1 (tertinggi dulu)");

        // Debug: Show top 10 siswa
        $this->line("\n📈 Top 10 Siswa by Pilihan 1 Score:");
        for ($i = 0; $i < min(10, count($siswas)); $i++) {
            $siswaDebug = $siswas[$i];
            $skorDebug = $skorCache[$siswaDebug->id];
            $no = $i + 1;
            $this->line("  {$no}. {$siswaDebug->nama} (NIS: {$siswaDebug->nis}) - Skor: {$skorDebug}");
        }

        $bar = $this->output->createProgressBar($totalSiswa);
        $bar->start();

        foreach ($siswas as $siswa) {
            // Hitung skor untuk setiap pilihan
            $pilihanScores = [];

            // Hitung sisa kursi FRESH dari database setiap iterasi
            if ($siswa->pilihan_peminatan_1) {
                $skor1 = $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_1);
                $sisaKursi1 = Peminatan::find($siswa->pilihan_peminatan_1)?->sisaKursi() ?? 0;
                $pilihanScores[1] = [
                    'peminatan_id' => $siswa->pilihan_peminatan_1,
                    'skor' => $skor1,
                    'sisa_kursi' => $sisaKursi1
                ];
            }

            if ($siswa->pilihan_peminatan_2) {
                $skor2 = $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_2);
                $sisaKursi2 = Peminatan::find($siswa->pilihan_peminatan_2)?->sisaKursi() ?? 0;
                $pilihanScores[2] = [
                    'peminatan_id' => $siswa->pilihan_peminatan_2,
                    'skor' => $skor2,
                    'sisa_kursi' => $sisaKursi2
                ];
            }

            if ($siswa->pilihan_peminatan_3) {
                $skor3 = $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_3);
                $sisaKursi3 = Peminatan::find($siswa->pilihan_peminatan_3)?->sisaKursi() ?? 0;
                $pilihanScores[3] = [
                    'peminatan_id' => $siswa->pilihan_peminatan_3,
                    'skor' => $skor3,
                    'sisa_kursi' => $sisaKursi3
                ];
            }

            // Tentukan alokasi berdasarkan preferensi pilihan (1, 2, 3)
            $alokasiTentative = null;
            $skorAlokasi = $pilihanScores[1]['skor'] ?? 0;  // ✅ Skor PILIHAN 1 untuk disimpan
            $statusAlokasi = null;

            // Cek pilihan 1, 2, 3 secara berurutan
            for ($pilihan = 1; $pilihan <= 3; $pilihan++) {
                if (isset($pilihanScores[$pilihan])) {
                    $kursi = $pilihanScores[$pilihan]['sisa_kursi'];

                    if ($kursi > 0) {
                        // Ada kursi di pilihan ini, DITERIMA
                        $alokasiTentative = $pilihanScores[$pilihan]['peminatan_id'];
                        $statusAlokasi = 'diterima';

                        // ✅ Kurangi kuota dengan ATOMIC decrement
                        Peminatan::where('id', $pilihanScores[$pilihan]['peminatan_id'])
                            ->decrement('kuota', 1);
                        break;
                    }
                }
            }

            // Jika semua pilihan penuh, masuk waitlist di pilihan dengan skor tertinggi
            if (!$alokasiTentative && !empty($pilihanScores)) {
                // Cari pilihan dengan skor tertinggi
                $skorTertinggi = 0;
                $pilihanTertinggi = null;

                for ($i = 1; $i <= 3; $i++) {
                    if (isset($pilihanScores[$i]) && $pilihanScores[$i]['skor'] > $skorTertinggi) {
                        $skorTertinggi = $pilihanScores[$i]['skor'];
                        $pilihanTertinggi = $i;
                    }
                }

                if ($pilihanTertinggi) {
                    $alokasiTentative = $pilihanScores[$pilihanTertinggi]['peminatan_id'];
                    $statusAlokasi = 'waitlist';
                    // ✅ Skor tetap skor PILIHAN 1 (tidak berubah)
                }
            }

            // Simpan alokasi
            if ($alokasiTentative) {
                Alokasi::create([
                    'siswa_id' => $siswa->id,
                    'peminatan_id' => $alokasiTentative,
                    'skor_saw' => $skorAlokasi,
                    'status' => $statusAlokasi
                ]);

                if ($statusAlokasi === 'diterima') {
                    $diterima++;
                } else {
                    $waitlist++;
                }
            } else {
                $ditolak++;
            }

            $bar->advance();
        }

        $bar->finish();

        $this->info("\n\n✅ Alokasi selesai!");
        $this->line("📊 Hasil:");
        $this->line("   • Diterima: <fg=green>{$diterima}</>");
        $this->line("   • Waitlist: <fg=yellow>{$waitlist}</>");
        $this->line("   • Ditolak: <fg=red>{$ditolak}</>");
    }

    /**
     * Hitung skor SAW
     */
    private function hitungSkorSaw($siswa, $peminatanId)
    {
        $kriterias = \App\Models\Kriteria::where('peminatan_id', $peminatanId)->get();

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

        return $totalSkor;
    }
}
