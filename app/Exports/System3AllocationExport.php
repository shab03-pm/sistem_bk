<?php

namespace App\Exports;

use App\Models\Alokasi;
use App\Models\Peminatan;
use App\Models\Siswa;
use App\Models\Kriteria;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Helper class untuk generate rumus SAW
 */
class SawFormulaHelper
{
    /**
     * Generate rumus SAW untuk setiap kriteria
     * Menampilkan: (nilai1/max1)*bobot1 + (nilai2/max2)*bobot2 + ...
     */
    public static function generateSawFormula($siswa, $peminatanId)
    {
        $kriterias = Kriteria::where('peminatan_id', $peminatanId)
            ->orderBy('id')
            ->get();

        if ($kriterias->isEmpty()) {
            return 'Tidak ada kriteria';
        }

        $formulas = [];
        foreach ($kriterias as $kriteria) {
            $mapel = $kriteria->mapel;
            $bobot = $kriteria->bobot;
            $nilai = $siswa->{'nilai_' . $mapel} ?? 0;

            // Cari max nilai
            $maxNilai = Siswa::whereNotNull('nilai_' . $mapel)
                ->max('nilai_' . $mapel) ?? 100;

            $formulas[] = "($nilai/$maxNilai)*$bobot";
        }

        return implode(' + ', $formulas);
    }
}

/**
 * Sheet Ringkasan - Summary per Peminatan
 */
class RingkasanAllocationSheet implements FromArray, WithTitle, WithHeadings, ShouldAutoSize
{
    public function title(): string
    {
        return 'Ringkasan';
    }

    public function headings(): array
    {
        return [
            'No',
            'Peminatan',
            'Kuota',
            'Diterima',
            'Waiting List',
            'Sisa Kursi',
            'Persentase Terisi'
        ];
    }

    public function array(): array
    {
        $data = [];
        $no = 1;

        foreach (Peminatan::orderBy('nama')->get() as $peminatan) {
            $diterima = $peminatan->alokasis()
                ->where('status', 'diterima')
                ->count();
            $waitlist = $peminatan->alokasis()
                ->where('status', 'waitlist')
                ->count();
            $sisaKursi = max(0, $peminatan->kuota_maksimal - $diterima);
            $persentase = $peminatan->kuota_maksimal > 0
                ? round(($diterima / $peminatan->kuota_maksimal) * 100, 2)
                : 0;

            $data[] = [
                $no++,
                $peminatan->nama,
                $peminatan->kuota_maksimal,
                $diterima,
                $waitlist,
                $sisaKursi,
                $persentase . '%'
            ];
        }

        return $data;
    }
}

/**
 * Sheet Per Peminatan - Detail siswa dengan skor breakdown
 */
class DetailPerPeminatanSheet implements FromArray, WithTitle, WithHeadings, ShouldAutoSize
{
    private $peminatan;

    public function __construct(Peminatan $peminatan)
    {
        $this->peminatan = $peminatan;
    }

    public function title(): string
    {
        return substr($this->peminatan->nama, 0, 31);
    }

    public function headings(): array
    {
        return [
            'No',
            'Status',
            'NIS',
            'Nama Siswa',
            'Kelas Asal',
            'Matematika',
            'Fisika',
            'Kimia',
            'Biologi',
            'TIK',
            'B. Inggris',
            'Sosiologi',
            'Ekonomi',
            'Geografi',
            'Pilihan 1',
            'Pilihan 2',
            'Pilihan 3',
            'Skor P1',
            'Rumus P1',
            'Skor P2',
            'Rumus P2',
            'Skor P3',
            'Rumus P3',
            'Ranking P1',
            'Ranking P2',
            'Ranking P3',
            'Alokasi Ke',
            'Alasan Alokasi'
        ];
    }

    public function array(): array
    {
        $data = [];
        $no = 1;

        // Get all alokasis untuk peminatan ini
        $alokasis = Alokasi::where('peminatan_id', $this->peminatan->id)
            ->orderByRaw("FIELD(status, 'diterima', 'waitlist')")
            ->with([
                'siswa' => function ($query) {
                    $query->with('pilihanPeminatan1', 'pilihanPeminatan2', 'pilihanPeminatan3');
                }
            ])
            ->get();

        foreach ($alokasis as $alokasi) {
            $siswa = $alokasi->siswa;

            // Get skor untuk semua pilihan
            $skor_p1 = $alokasi->skor_pilihan_1 ?? 0;
            $skor_p2 = $alokasi->skor_pilihan_2 ?? 0;
            $skor_p3 = $alokasi->skor_pilihan_3 ?? 0;

            // Get nama 3 pilihan
            $pilihan1 = $siswa->pilihan_peminatan_1 ? ($siswa->pilihanPeminatan1->nama ?? 'N/A') : '-';
            $pilihan2 = $siswa->pilihan_peminatan_2 ? ($siswa->pilihanPeminatan2->nama ?? 'N/A') : '-';
            $pilihan3 = $siswa->pilihan_peminatan_3 ? ($siswa->pilihanPeminatan3->nama ?? 'N/A') : '-';

            // Get rumus SAW untuk setiap pilihan
            $rumusP1 = $siswa->pilihan_peminatan_1 ? SawFormulaHelper::generateSawFormula($siswa, $siswa->pilihan_peminatan_1) : '-';
            $rumusP2 = $siswa->pilihan_peminatan_2 ? SawFormulaHelper::generateSawFormula($siswa, $siswa->pilihan_peminatan_2) : '-';
            $rumusP3 = $siswa->pilihan_peminatan_3 ? SawFormulaHelper::generateSawFormula($siswa, $siswa->pilihan_peminatan_3) : '-';

            // Get ranking per pilihan
            $rankingP1 = $this->getRanking($siswa->pilihan_peminatan_1, 'skor_pilihan_1', $skor_p1);
            $rankingP2 = $this->getRanking($siswa->pilihan_peminatan_2, 'skor_pilihan_2', $skor_p2);
            $rankingP3 = $this->getRanking($siswa->pilihan_peminatan_3, 'skor_pilihan_3', $skor_p3);

            // Determine alasan alokasi
            $alasan = $this->getAlasanAlokasi($siswa, $this->peminatan->id, $skor_p1, $skor_p2, $skor_p3);

            $data[] = [
                $no++,
                strtoupper($alokasi->status),
                $siswa->nis,
                $siswa->nama,
                $siswa->kelas_asal,
                $siswa->nilai_matematika ?? 0,
                $siswa->nilai_fisika ?? 0,
                $siswa->nilai_kimia ?? 0,
                $siswa->nilai_biologi ?? 0,
                $siswa->nilai_tik ?? 0,
                $siswa->nilai_binggris ?? 0,
                $siswa->nilai_sosiologi ?? 0,
                $siswa->nilai_ekonomi ?? 0,
                $siswa->nilai_geografi ?? 0,
                $pilihan1,
                $pilihan2,
                $pilihan3,
                number_format($skor_p1, 4),
                $rumusP1,
                number_format($skor_p2, 4),
                $rumusP2,
                number_format($skor_p3, 4),
                $rumusP3,
                $rankingP1,
                $rankingP2,
                $rankingP3,
                $this->peminatan->nama,
                $alasan
            ];
        }

        return $data;
    }

    /**
     * Get alasan mengapa siswa dialokasikan ke peminatan ini
     */
    private function getAlasanAlokasi($siswa, $targetPeminatanId, $skor_p1, $skor_p2, $skor_p3)
    {
        $p1_id = $siswa->pilihan_peminatan_1;
        $p2_id = $siswa->pilihan_peminatan_2;
        $p3_id = $siswa->pilihan_peminatan_3;

        if ($targetPeminatanId == $p1_id) {
            return "Diterima P1 (Skor: " . number_format($skor_p1, 4) . ")";
        } elseif ($targetPeminatanId == $p2_id) {
            return "P1 Penuh → Alokasi P2 (Skor: " . number_format($skor_p2, 4) . ")";
        } elseif ($targetPeminatanId == $p3_id) {
            return "P1 & P2 Penuh → Alokasi P3 (Skor: " . number_format($skor_p3, 4) . ")";
        } else {
            return "Alokasi Alternatif (Sisa Kursi)";
        }
    }

    /**
     * Get ranking siswa dalam pilihan tertentu
     */
    private function getRanking($peminatanId, $skorColumn, $siswaScore)
    {
        if (!$peminatanId)
            return '-';

        $count = Alokasi::where('peminatan_id', $peminatanId)
            ->where('status', 'diterima')
            ->whereRaw("$skorColumn > ?", [$siswaScore])
            ->count();

        return $count + 1;
    }
}

/**
 * Sheet Waiting List - Semua siswa waiting list
 */
class WaitlistAllocationSheet implements FromArray, WithTitle, WithHeadings, ShouldAutoSize
{
    public function title(): string
    {
        return 'Waiting List';
    }

    public function headings(): array
    {
        return [
            'No',
            'NIS',
            'Nama Siswa',
            'Kelas Asal',
            'Matematika',
            'Fisika',
            'Kimia',
            'Biologi',
            'TIK',
            'B. Inggris',
            'Sosiologi',
            'Ekonomi',
            'Geografi',
            'Pilihan 1',
            'Pilihan 2',
            'Pilihan 3',
            'Skor P1',
            'Skor P2',
            'Skor P3',
            'Alokasi Waiting List',
            'Alasan'
        ];
    }

    public function array(): array
    {
        $data = [];
        $no = 1;

        $alokasis = Alokasi::where('status', 'waitlist')
            ->with([
                'siswa' => function ($query) {
                    $query->with('pilihanPeminatan1', 'pilihanPeminatan2', 'pilihanPeminatan3');
                },
                'peminatan'
            ])
            ->orderBy('created_at')
            ->get();

        foreach ($alokasis as $alokasi) {
            $siswa = $alokasi->siswa;

            $skor_p1 = $alokasi->skor_pilihan_1 ?? 0;
            $skor_p2 = $alokasi->skor_pilihan_2 ?? 0;
            $skor_p3 = $alokasi->skor_pilihan_3 ?? 0;

            // Get nama 3 pilihan
            $pilihan1 = $siswa->pilihan_peminatan_1 ? ($siswa->pilihanPeminatan1->nama ?? 'N/A') : '-';
            $pilihan2 = $siswa->pilihan_peminatan_2 ? ($siswa->pilihanPeminatan2->nama ?? 'N/A') : '-';
            $pilihan3 = $siswa->pilihan_peminatan_3 ? ($siswa->pilihanPeminatan3->nama ?? 'N/A') : '-';

            $alasan = "Semua pilihan penuh → Alokasi alternatif ke " . $alokasi->peminatan->nama;

            $data[] = [
                $no++,
                $siswa->nis,
                $siswa->nama,
                $siswa->kelas_asal,
                $siswa->nilai_matematika ?? 0,
                $siswa->nilai_fisika ?? 0,
                $siswa->nilai_kimia ?? 0,
                $siswa->nilai_biologi ?? 0,
                $siswa->nilai_tik ?? 0,
                $siswa->nilai_binggris ?? 0,
                $siswa->nilai_sosiologi ?? 0,
                $siswa->nilai_ekonomi ?? 0,
                $siswa->nilai_geografi ?? 0,
                $pilihan1,
                $pilihan2,
                $pilihan3,
                number_format($skor_p1, 4),
                number_format($skor_p2, 4),
                number_format($skor_p3, 4),
                $alokasi->peminatan->nama,
                $alasan
            ];
        }

        return $data;
    }
}

/**
 * Sheet Rincian SAW - Breakdown detail perhitungan SAW setiap siswa
 */
class RincianSawSheet implements FromArray, WithTitle, WithHeadings, ShouldAutoSize
{
    public function title(): string
    {
        return 'Rincian SAW';
    }

    public function headings(): array
    {
        return [
            'No',
            'NIS',
            'Nama Siswa',
            'Pilihan',
            'Mapel Kriteria',
            'Nilai Siswa',
            'Nilai Max',
            'Bobot (%)',
            'Perhitungan',
            'Hasil Perhitungan',
            'Total Skor Pilihan'
        ];
    }

    public function array(): array
    {
        $data = [];
        $no = 1;

        // Get semua siswa dengan pilihan mereka
        $siswas = Siswa::with([
            'pilihanPeminatan1' => function ($q) {
                $q->with('kriterias'); },
            'pilihanPeminatan2' => function ($q) {
                $q->with('kriterias'); },
            'pilihanPeminatan3' => function ($q) {
                $q->with('kriterias'); },
            'alokasi'
        ])->orderBy('id')->get();

        foreach ($siswas as $siswa) {
            // Process 3 pilihan
            $pilihans = [
                ['id' => $siswa->pilihan_peminatan_1, 'skor' => null, 'peminatan' => $siswa->pilihanPeminatan1, 'label' => 'P1'],
                ['id' => $siswa->pilihan_peminatan_2, 'skor' => null, 'peminatan' => $siswa->pilihanPeminatan2, 'label' => 'P2'],
                ['id' => $siswa->pilihan_peminatan_3, 'skor' => null, 'peminatan' => $siswa->pilihanPeminatan3, 'label' => 'P3'],
            ];

            // Get skor dari alokasi
            if ($siswa->alokasi) {
                if ($siswa->pilihan_peminatan_1 == $siswa->alokasi->peminatan_id) {
                    $pilihans[0]['skor'] = $siswa->alokasi->skor_pilihan_1;
                } elseif ($siswa->pilihan_peminatan_2 == $siswa->alokasi->peminatan_id) {
                    $pilihans[1]['skor'] = $siswa->alokasi->skor_pilihan_2;
                } elseif ($siswa->pilihan_peminatan_3 == $siswa->alokasi->peminatan_id) {
                    $pilihans[2]['skor'] = $siswa->alokasi->skor_pilihan_3;
                }
            }

            foreach ($pilihans as $pilihan) {
                if (!$pilihan['id'] || !$pilihan['peminatan']) {
                    continue;
                }

                $peminatan = $pilihan['peminatan'];
                $kriterias = $peminatan->kriterias()->orderBy('id')->get();

                $isFirstRow = true;

                foreach ($kriterias as $kriteria) {
                    $mapel = $kriteria->mapel;
                    $bobot = $kriteria->bobot * 100; // Convert to percentage
                    $nilai = $siswa->{'nilai_' . $mapel} ?? 0;

                    // Get max nilai
                    $maxNilai = Siswa::whereNotNull('nilai_' . $mapel)
                        ->max('nilai_' . $mapel) ?? 100;

                    // Perhitungan: (nilai/max)*bobot
                    $normalisasi = $maxNilai > 0 ? $nilai / $maxNilai : 0;
                    $hasilPerhitungan = $normalisasi * ($kriteria->bobot);

                    // Format mapel name
                    $mapelDisplay = ucfirst(str_replace('_', ' ', $mapel));

                    $perhitunganFormula = "($nilai/$maxNilai)*" . number_format($kriteria->bobot, 2);

                    // Get total skor untuk pilihan ini
                    $totalSkor = 0;
                    foreach ($kriterias as $k) {
                        $n = $siswa->{'nilai_' . $k->mapel} ?? 0;
                        $maxN = Siswa::whereNotNull('nilai_' . $k->mapel)->max('nilai_' . $k->mapel) ?? 100;
                        $totalSkor += ($maxN > 0 ? $n / $maxN : 0) * $k->bobot;
                    }

                    $data[] = [
                        $isFirstRow ? $no : '',
                        $isFirstRow ? $siswa->nis : '',
                        $isFirstRow ? $siswa->nama : '',
                        $isFirstRow ? $pilihan['label'] . ' - ' . $peminatan->nama : '',
                        $mapelDisplay,
                        $nilai,
                        $maxNilai,
                        number_format($bobot, 2),
                        $perhitunganFormula,
                        number_format($hasilPerhitungan, 4),
                        $isFirstRow ? number_format($totalSkor, 4) : ''
                    ];

                    $isFirstRow = false;
                }

                $no++;
            }
        }

        return $data;
    }
}

/**
 * Sheet Siswa Per Kelas - Daftar lengkap siswa per kelas dengan status alokasi
 */
class SiswaPerKelasSheet implements FromArray, WithTitle, WithHeadings, ShouldAutoSize
{
    public function title(): string
    {
        return 'Siswa Per Kelas';
    }

    public function headings(): array
    {
        return [
            'No',
            'Kelas',
            'NIS',
            'Nama Siswa',
            'Matematika',
            'Fisika',
            'Kimia',
            'Biologi',
            'TIK',
            'B. Inggris',
            'Sosiologi',
            'Ekonomi',
            'Geografi',
            'Pilihan 1',
            'Pilihan 2',
            'Pilihan 3',
            'Skor P1',
            'Skor P2',
            'Skor P3',
            'Status Alokasi',
            'Alokasi Ke',
            'Ranking P1',
            'Ranking P2',
            'Ranking P3'
        ];
    }

    public function array(): array
    {
        $data = [];
        $no = 1;

        // Get semua siswa, dikelompokkan per kelas
        $siswas = Siswa::orderBy('kelas_asal')
            ->orderBy('nama')
            ->with(['pilihanPeminatan1', 'pilihanPeminatan2', 'pilihanPeminatan3', 'alokasi'])
            ->get();

        foreach ($siswas as $siswa) {
            // Get alokasi jika ada
            $alokasi = $siswa->alokasi;
            $status = $alokasi ? strtoupper($alokasi->status) : 'BELUM DIALOKASI';
            $alokasiKe = $alokasi ? ($alokasi->peminatan->nama ?? 'N/A') : '-';

            // Get skor
            $skor_p1 = $alokasi ? ($alokasi->skor_pilihan_1 ?? 0) : 0;
            $skor_p2 = $alokasi ? ($alokasi->skor_pilihan_2 ?? 0) : 0;
            $skor_p3 = $alokasi ? ($alokasi->skor_pilihan_3 ?? 0) : 0;

            // Get nama pilihan
            $pilihan1 = $siswa->pilihan_peminatan_1 ? ($siswa->pilihanPeminatan1->nama ?? 'N/A') : '-';
            $pilihan2 = $siswa->pilihan_peminatan_2 ? ($siswa->pilihanPeminatan2->nama ?? 'N/A') : '-';
            $pilihan3 = $siswa->pilihan_peminatan_3 ? ($siswa->pilihanPeminatan3->nama ?? 'N/A') : '-';

            // Get ranking
            $rankingP1 = $this->getRanking($siswa->pilihan_peminatan_1, 'skor_pilihan_1', $skor_p1);
            $rankingP2 = $this->getRanking($siswa->pilihan_peminatan_2, 'skor_pilihan_2', $skor_p2);
            $rankingP3 = $this->getRanking($siswa->pilihan_peminatan_3, 'skor_pilihan_3', $skor_p3);

            $data[] = [
                $no++,
                $siswa->kelas_asal,
                $siswa->nis,
                $siswa->nama,
                $siswa->nilai_matematika ?? 0,
                $siswa->nilai_fisika ?? 0,
                $siswa->nilai_kimia ?? 0,
                $siswa->nilai_biologi ?? 0,
                $siswa->nilai_tik ?? 0,
                $siswa->nilai_binggris ?? 0,
                $siswa->nilai_sosiologi ?? 0,
                $siswa->nilai_ekonomi ?? 0,
                $siswa->nilai_geografi ?? 0,
                $pilihan1,
                $pilihan2,
                $pilihan3,
                number_format($skor_p1, 4),
                number_format($skor_p2, 4),
                number_format($skor_p3, 4),
                $status,
                $alokasiKe,
                $rankingP1,
                $rankingP2,
                $rankingP3
            ];
        }

        return $data;
    }

    /**
     * Get ranking siswa dalam pilihan tertentu
     */
    private function getRanking($peminatanId, $skorColumn, $siswaScore)
    {
        if (!$peminatanId)
            return '-';

        $count = Alokasi::where('peminatan_id', $peminatanId)
            ->where('status', 'diterima')
            ->whereRaw("$skorColumn > ?", [$siswaScore])
            ->count();

        return $count + 1;
    }
}

/**
 * Main Export Class - 10 Sheets Total
 * 1. Ringkasan
 * 2-8. Per PAKET (7 sheets)
 * 9. Waiting List
 * 10. Siswa Per Kelas
 */
class System3AllocationExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [
            new RingkasanAllocationSheet(),
        ];

        // Add detail sheets untuk setiap peminatan
        foreach (Peminatan::orderBy('nama')->get() as $peminatan) {
            $sheets[] = new DetailPerPeminatanSheet($peminatan);
        }

        // Add waiting list sheet
        $sheets[] = new WaitlistAllocationSheet();

        // Add rincian SAW sheet
        $sheets[] = new RincianSawSheet();

        // Add siswa per kelas sheet
        $sheets[] = new SiswaPerKelasSheet();

        return $sheets;
    }
}
