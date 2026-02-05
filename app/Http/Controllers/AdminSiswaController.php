<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Alokasi;
use App\Models\Peminatan;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminSiswaController extends Controller
{
    /**
     * Profil Siswa - Daftar semua siswa
     */
    public function profilSiswa(Request $request)
    {
        $query = Siswa::query();

        // Search
        if ($request->search) {
            $query->where('nis', 'like', '%' . $request->search . '%')
                ->orWhere('nama', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        // Filter by kelas
        if ($request->kelas) {
            $query->where('kelas_asal', $request->kelas);
        }

        $siswas = $query->paginate(15);

        // Statistik - Hitung dari SEMUA siswa (bukan yang dipaginasi)
        $totalSiswa = Siswa::count();
        $perKelasAll = Siswa::selectRaw('kelas_asal, count(*) as total')
            ->groupBy('kelas_asal')
            ->orderBy('kelas_asal')
            ->get();

        $stats = [
            'total' => $totalSiswa,
            'per_kelas' => $perKelasAll,
        ];

        // Daftar kelas untuk filter dropdown
        $kelasList = Siswa::distinct()->orderBy('kelas_asal')->pluck('kelas_asal');

        return view('admin.siswa.profil-siswa.index', compact('siswas', 'stats', 'kelasList'));
    }

    /**
     * Show Detail Siswa
     */
    public function showSiswa($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('admin.siswa.show', compact('siswa'));
    }

    /**
     * Edit Siswa
     */
    public function editSiswa($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('admin.siswa.edit', compact('siswa'));
    }

    /**
     * Update Siswa
     */
    public function updateSiswa(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->update($request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|unique:siswas,nis,' . $id,
            'email' => 'required|email|unique:siswas,email,' . $id,
            'kelas_asal' => 'required|string|max:50',
        ]));
        return redirect()->route('admin.siswa.profil')->with('success', 'Data siswa berhasil diperbarui');
    }

    /**
     * Download Raport File
     */
    public function downloadRaport($id)
    {
        $siswa = Siswa::findOrFail($id);

        if (!$siswa->file_raport) {
            return redirect()->back()->with('error', 'File raport untuk siswa ' . $siswa->nama . ' belum tersedia');
        }

        // Redirect ke file URL langsung (sudah bisa diakses via symlink)
        return redirect(asset('storage/raport/' . $siswa->file_raport));
    }

    /**
     * Input Nilai Raport - Monitoring nilai siswa
     */
    public function inputNilai(Request $request)
    {
        $query = Siswa::query();

        // Search
        if ($request->search) {
            $query->where('nis', 'like', '%' . $request->search . '%')
                ->orWhere('nama', 'like', '%' . $request->search . '%');
        }

        // Filter status kelengkapan
        if ($request->status === 'lengkap') {
            $query->whereNotNull('nilai_matematika')
                ->whereNotNull('nilai_fisika')
                ->whereNotNull('nilai_kimia')
                ->whereNotNull('nilai_biologi')
                ->whereNotNull('nilai_tik')
                ->whereNotNull('nilai_binggris')
                ->whereNotNull('nilai_sosiologi')
                ->whereNotNull('nilai_ekonomi')
                ->whereNotNull('nilai_geografi');
        } elseif ($request->status === 'belum') {
            $query->where(function ($q) {
                $q->whereNull('nilai_matematika')
                    ->orWhereNull('nilai_fisika')
                    ->orWhereNull('nilai_kimia')
                    ->orWhereNull('nilai_biologi')
                    ->orWhereNull('nilai_tik')
                    ->orWhereNull('nilai_binggris')
                    ->orWhereNull('nilai_sosiologi')
                    ->orWhereNull('nilai_ekonomi')
                    ->orWhereNull('nilai_geografi');
            });
        }

        // Order
        $orderBy = $request->order_by ?? 'nama';
        $order = $request->order === 'desc' ? 'desc' : 'asc';
        $query->orderBy($orderBy, $order);

        $siswas = $query->paginate(15);

        // Statistik
        $totalSiswa = Siswa::count();
        $siswaLengkap = Siswa::whereNotNull('nilai_matematika')
            ->whereNotNull('nilai_fisika')
            ->whereNotNull('nilai_kimia')
            ->whereNotNull('nilai_biologi')
            ->whereNotNull('nilai_tik')
            ->whereNotNull('nilai_binggris')
            ->whereNotNull('nilai_sosiologi')
            ->whereNotNull('nilai_ekonomi')
            ->whereNotNull('nilai_geografi')
            ->count();

        $persentaseLengkap = $totalSiswa > 0 ? round(($siswaLengkap / $totalSiswa) * 100, 2) : 0;

        // Rata-rata nilai
        $rataRataNilai = [
            'matematika' => round(Siswa::whereNotNull('nilai_matematika')->avg('nilai_matematika'), 2),
            'fisika' => round(Siswa::whereNotNull('nilai_fisika')->avg('nilai_fisika'), 2),
            'kimia' => round(Siswa::whereNotNull('nilai_kimia')->avg('nilai_kimia'), 2),
            'biologi' => round(Siswa::whereNotNull('nilai_biologi')->avg('nilai_biologi'), 2),
            'tik' => round(Siswa::whereNotNull('nilai_tik')->avg('nilai_tik'), 2),
            'binggris' => round(Siswa::whereNotNull('nilai_binggris')->avg('nilai_binggris'), 2),
            'sosiologi' => round(Siswa::whereNotNull('nilai_sosiologi')->avg('nilai_sosiologi'), 2),
            'ekonomi' => round(Siswa::whereNotNull('nilai_ekonomi')->avg('nilai_ekonomi'), 2),
            'geografi' => round(Siswa::whereNotNull('nilai_geografi')->avg('nilai_geografi'), 2),
        ];

        $stats = [
            'total' => $totalSiswa,
            'lengkap' => $siswaLengkap,
            'belum' => $totalSiswa - $siswaLengkap,
            'persentase' => $persentaseLengkap,
            'rata_rata' => $rataRataNilai,
        ];

        return view('admin.siswa.input-nilai-raport.index', compact('siswas', 'stats'));
    }

    /**
     * Show Detail Nilai Siswa
     */
    public function showNilai($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('admin.siswa.input-nilai-raport.show', compact('siswa'));
    }

    /**
     * Edit Nilai Siswa
     */
    public function editNilai($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('admin.siswa.input-nilai-raport.edit', compact('siswa'));
    }

    /**
     * Update Nilai Siswa
     */
    public function updateNilai(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->update($request->validate([
            'nilai_matematika' => 'nullable|numeric|min:0|max:100',
            'nilai_fisika' => 'nullable|numeric|min:0|max:100',
            'nilai_kimia' => 'nullable|numeric|min:0|max:100',
            'nilai_biologi' => 'nullable|numeric|min:0|max:100',
            'nilai_tik' => 'nullable|numeric|min:0|max:100',
            'nilai_binggris' => 'nullable|numeric|min:0|max:100',
            'nilai_sosiologi' => 'nullable|numeric|min:0|max:100',
            'nilai_ekonomi' => 'nullable|numeric|min:0|max:100',
            'nilai_geografi' => 'nullable|numeric|min:0|max:100',
        ]));
        return redirect()->route('admin.siswa.input-nilai.show', $siswa->id)->with('success', 'Nilai siswa berhasil diperbarui');
    }

    /**
     * Delete Nilai Siswa
     */
    public function deleteNilai($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->update([
            'nilai_matematika' => null,
            'nilai_fisika' => null,
            'nilai_kimia' => null,
            'nilai_biologi' => null,
            'nilai_tik' => null,
            'nilai_binggris' => null,
            'nilai_sosiologi' => null,
            'nilai_ekonomi' => null,
            'nilai_geografi' => null,
        ]);
        return redirect()->route('admin.siswa.input-nilai')->with('success', 'Data nilai siswa berhasil dihapus');
    }

    /**
     * Pilih Peminatan - Monitoring pilihan peminatan
     */
    public function pilihPeminatan(Request $request)
    {
        $query = Siswa::query();

        // Search
        if ($request->search) {
            $query->where('nis', 'like', '%' . $request->search . '%')
                ->orWhere('nama', 'like', '%' . $request->search . '%');
        }

        // Filter status
        if ($request->status === 'sudah') {
            $query->whereNotNull('pilihan_peminatan_1')
                ->whereNotNull('pilihan_peminatan_2')
                ->whereNotNull('pilihan_peminatan_3');
        } elseif ($request->status === 'belum') {
            $query->where(function ($q) {
                $q->whereNull('pilihan_peminatan_1')
                    ->orWhereNull('pilihan_peminatan_2')
                    ->orWhereNull('pilihan_peminatan_3');
            });
        }

        $siswas = $query->with('pilihanPeminatan1', 'pilihanPeminatan2', 'pilihanPeminatan3')
            ->paginate(15);

        // Statistik
        $totalSiswa = Siswa::count();
        $sudahPilih = Siswa::whereNotNull('pilihan_peminatan_1')
            ->whereNotNull('pilihan_peminatan_2')
            ->whereNotNull('pilihan_peminatan_3')
            ->count();

        $persentase = $totalSiswa > 0 ? round(($sudahPilih / $totalSiswa) * 100, 2) : 0;

        // Distribusi pilihan (hanya Pilihan 1)
        $distribusi = [];
        $peminatans = Peminatan::all();
        foreach ($peminatans as $peminatan) {
            $distribusi[$peminatan->nama] = Siswa::where('pilihan_peminatan_1', $peminatan->id)->count();
        }

        $stats = [
            'total' => $totalSiswa,
            'sudah' => $sudahPilih,
            'belum' => $totalSiswa - $sudahPilih,
            'persentase' => $persentase,
            'distribusi' => $distribusi,
        ];

        return view('admin.siswa.pilih-peminatan.index', compact('siswas', 'stats'));
    }

    /**
     * Hasil Seleksi - Monitoring hasil alokasi
     */
    public function hasilSeleksi(Request $request)
    {
        $query = Siswa::with('pilihanPeminatan1', 'pilihanPeminatan2', 'pilihanPeminatan3', 'alokasi.peminatan');

        // Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nis', 'like', '%' . $request->search . '%')
                    ->orWhere('nama', 'like', '%' . $request->search . '%');
            });
        }

        // Filter status - khusus untuk diterima atau waitlist
        $status = $request->input('status');

        if ($status === 'diterima') {
            $query->whereHas('alokasi', function ($q) {
                $q->where('status', 'diterima');
            });
            // Filter peminatan hanya untuk yang diterima
            if ($request->peminatan_id) {
                $query->whereHas('alokasi', function ($q) use ($request) {
                    $q->where('peminatan_id', $request->peminatan_id)
                        ->where('status', 'diterima');
                });
            }
        } elseif ($status === 'waitlist') {
            $query->whereHas('alokasi', function ($q) {
                $q->where('status', 'waitlist');
            });
            // Untuk waitlist, peminatan_id filter tidak berlaku
        } else {
            // Jika tidak ada filter status, tampilkan semua
            if ($request->peminatan_id) {
                $query->whereHas('alokasi', function ($q) use ($request) {
                    $q->where('peminatan_id', $request->peminatan_id);
                });
            }
        }

        $siswas = $query->orderBy('nis')->paginate(15);

        // Transform data untuk konsistensi dengan view
        $alokas = collect($siswas->items())->map(function ($siswa) {
            $alokasi = $siswa->alokasi;
            $skorSaw = $alokasi?->skor_saw ?? 0;
            $peminatan = $alokasi?->peminatan;

            return (object) [
                'id' => $alokasi?->id,
                'siswa_id' => $siswa->id,
                'siswa' => (object) [
                    'nis' => $siswa->nis,
                    'nama' => $siswa->nama,
                    'kelas_asal' => $siswa->kelas_asal,
                    'pilihanPeminatan1' => $siswa->pilihanPeminatan1,
                    'pilihanPeminatan2' => $siswa->pilihanPeminatan2,
                    'pilihanPeminatan3' => $siswa->pilihanPeminatan3,
                ],
                'peminatan' => $peminatan ? (object) ['nama' => $peminatan->nama] : null,
                'skor_saw' => $skorSaw,
                'status' => $alokasi?->status ?? 'waitlist',
                'created_at' => $siswa->created_at,
            ];
        });

        // Buat pagination object baru dengan data yang sudah ditransform
        $result = new \Illuminate\Pagination\LengthAwarePaginator(
            $alokas,
            $siswas->total(),
            $siswas->perPage(),
            $siswas->currentPage(),
            [
                'path' => $siswas->path(),
                'query' => $request->query(),
            ]
        );

        // Statistik
        $totalDiterima = Alokasi::where('status', 'diterima')->count();
        $totalWaitinglist = Alokasi::where('status', 'waitlist')->count();
        $totalSiswa = Siswa::count();

        // Distribusi per peminatan (hanya yang diterima)
        $distribusiPeminatan = Peminatan::withCount([
            'alokasis' => function ($q) {
                $q->where('status', 'diterima');
            }
        ])->get()->filter(function ($p) {
            return $p->alokasis_count > 0;
        })->values();

        $stats = [
            'total' => $totalDiterima,
            'waitinglist' => $totalWaitinglist,
            'distribusi' => $distribusiPeminatan,
        ];

        $peminatans = Peminatan::all();
        $isWaitlist = $request->status === 'waitlist';

        return view('admin.siswa.hasil-seleksi.index', compact('result', 'stats', 'peminatans', 'isWaitlist'));
    }

    /**
     * Show - Detail hasil alokasi siswa
     */
    public function showHasilSeleksi($id)
    {
        $alokasi = Alokasi::with('siswa', 'peminatan')->findOrFail($id);
        $siswa = $alokasi->siswa;

        // Hitung skor untuk ketiga pilihan peminatan
        $pilihanScores = [];

        if ($siswa->pilihan_peminatan_1) {
            $skor1 = $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_1);
            $total1 = Alokasi::where('peminatan_id', $siswa->pilihan_peminatan_1)
                ->where('status', 'diterima')
                ->count();
            $ranking1 = Alokasi::where('peminatan_id', $siswa->pilihan_peminatan_1)
                ->where('status', 'diterima')
                ->where('skor_saw', '>', $skor1)
                ->count() + 1;

            $pilihanScores[1] = [
                'peminatan' => $siswa->pilihanPeminatan1,
                'skor' => $skor1,
                'detail' => $this->getDetailSkorSaw($siswa, $siswa->pilihan_peminatan_1),
                'ranking' => $ranking1,
                'total_siswa' => $total1
            ];
        }

        if ($siswa->pilihan_peminatan_2) {
            $skor2 = $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_2);
            $total2 = Alokasi::where('peminatan_id', $siswa->pilihan_peminatan_2)
                ->where('status', 'diterima')
                ->count();
            $ranking2 = Alokasi::where('peminatan_id', $siswa->pilihan_peminatan_2)
                ->where('status', 'diterima')
                ->where('skor_saw', '>', $skor2)
                ->count() + 1;

            $pilihanScores[2] = [
                'peminatan' => $siswa->pilihanPeminatan2,
                'skor' => $skor2,
                'detail' => $this->getDetailSkorSaw($siswa, $siswa->pilihan_peminatan_2),
                'ranking' => $ranking2,
                'total_siswa' => $total2
            ];
        }

        if ($siswa->pilihan_peminatan_3) {
            $skor3 = $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_3);
            $total3 = Alokasi::where('peminatan_id', $siswa->pilihan_peminatan_3)
                ->where('status', 'diterima')
                ->count();
            $ranking3 = Alokasi::where('peminatan_id', $siswa->pilihan_peminatan_3)
                ->where('status', 'diterima')
                ->where('skor_saw', '>', $skor3)
                ->count() + 1;

            $pilihanScores[3] = [
                'peminatan' => $siswa->pilihanPeminatan3,
                'skor' => $skor3,
                'detail' => $this->getDetailSkorSaw($siswa, $siswa->pilihan_peminatan_3),
                'ranking' => $ranking3,
                'total_siswa' => $total3
            ];
        }

        // Tentukan pilihan mana yang terpilih (tertinggi)
        $terpilih = 0;
        $skorTertinggi = 0;
        foreach ($pilihanScores as $no => $data) {
            if ($data['skor'] > $skorTertinggi) {
                $skorTertinggi = $data['skor'];
                $terpilih = $no;
            }
        }

        // Ambil ranking dan total dari pilihan terpilih
        $ranking = $pilihanScores[$terpilih]['ranking'];
        $totalSiswa = $pilihanScores[$terpilih]['total_siswa'];

        return view('admin.siswa.hasil-seleksi.show', compact('alokasi', 'siswa', 'pilihanScores', 'terpilih', 'ranking', 'totalSiswa'));
    }

    /**
     * Skor SAW - Monitoring skor SAW dan ranking
     */
    public function skorSaw(Request $request)
    {
        $query = Alokasi::with('siswa', 'peminatan')
            ->whereHas('siswa'); // Ensure siswa exists

        // Search
        if ($request->search) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nis', 'like', '%' . $request->search . '%')
                    ->orWhere('nama', 'like', '%' . $request->search . '%');
            });
        }

        // Filter status
        $status = $request->input('status');
        if ($status === 'diterima') {
            $query->where('status', 'diterima');
        } elseif ($status === 'waitlist') {
            $query->where('status', 'waitlist');
        }
        // Jika kosong, tampilkan semua

        // Filter peminatan
        if ($request->peminatan_id) {
            $query->where('peminatan_id', $request->peminatan_id);
        }

        // Order
        $orderBy = $request->order_by ?? 'skor_saw';
        $order = $request->order === 'terendah' ? 'asc' : 'desc';
        $query->orderBy($orderBy, $order);

        $alokas = $query->paginate(15);

        // Tambahkan ranking - ranking global, bukan per halaman
        $allAlokas = Alokasi::orderBy('skor_saw', 'desc')->get();
        $rankingMap = [];
        foreach ($allAlokas as $index => $alokasi) {
            $rankingMap[$alokasi->id] = $index + 1;
        }

        // Statistik - berdasarkan filter
        $statsQuery = Alokasi::query();
        if ($status === 'diterima') {
            $statsQuery->where('status', 'diterima');
        } elseif ($status === 'waitlist') {
            $statsQuery->where('status', 'waitlist');
        }

        $totalProses = $statsQuery->count();
        $rataRataSkor = round($statsQuery->avg('skor_saw'), 2);
        $skorTertinggi = $statsQuery->max('skor_saw');
        $skorTerendah = $statsQuery->min('skor_saw');

        $stats = [
            'total' => $totalProses,
            'rata_rata' => $rataRataSkor,
            'tertinggi' => $skorTertinggi,
            'terendah' => $skorTerendah,
        ];

        $peminatans = Peminatan::all();

        return view('admin.siswa.skor-saw.index', compact('alokas', 'allAlokas', 'stats', 'peminatans', 'rankingMap'));
    }

    /**
     * Show Detail Pilihan Peminatan
     */
    public function showPilihanPeminatan($id)
    {
        $siswa = Siswa::with('pilihanPeminatan1', 'pilihanPeminatan2', 'pilihanPeminatan3')->findOrFail($id);
        return view('admin.siswa.pilih-peminatan.show', compact('siswa'));
    }

    /**
     * Edit Form Pilihan Peminatan
     */
    public function editPilihanPeminatan($id)
    {
        $siswa = Siswa::findOrFail($id);
        $peminatans = Peminatan::all();
        return view('admin.siswa.pilih-peminatan.edit', compact('siswa', 'peminatans'));
    }

    /**
     * Update Pilihan Peminatan
     */
    public function updatePilihanPeminatan(Request $request, $id)
    {
        $request->validate([
            'pilihan_peminatan_1' => 'nullable|exists:peminatans,id',
            'pilihan_peminatan_2' => 'nullable|exists:peminatans,id',
            'pilihan_peminatan_3' => 'nullable|exists:peminatans,id',
        ], [
            'pilihan_peminatan_1.exists' => 'Pilihan 1 tidak valid',
            'pilihan_peminatan_2.exists' => 'Pilihan 2 tidak valid',
            'pilihan_peminatan_3.exists' => 'Pilihan 3 tidak valid',
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update([
            'pilihan_peminatan_1' => $request->pilihan_peminatan_1 ?? $siswa->pilihan_peminatan_1,
            'pilihan_peminatan_2' => $request->pilihan_peminatan_2 ?? $siswa->pilihan_peminatan_2,
            'pilihan_peminatan_3' => $request->pilihan_peminatan_3 ?? $siswa->pilihan_peminatan_3,
        ]);

        return redirect()->route('admin.siswa.pilih-peminatan.show', $siswa->id)
            ->with('success', 'Pilihan peminatan berhasil diperbarui');
    }

    /**
     * Show - Detail skor SAW siswa
     */
    public function showSkorSaw($id)
    {
        $alokasi = Alokasi::with('siswa', 'peminatan')->findOrFail($id);
        $siswa = $alokasi->siswa;

        // Hitung skor untuk ketiga pilihan peminatan
        $pilihanScores = [];

        if ($siswa->pilihan_peminatan_1) {
            $peminatan1 = Peminatan::find($siswa->pilihan_peminatan_1);
            $skor1 = $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_1);

            // Hitung ranking untuk pilihan 1
            $total1 = Alokasi::where('peminatan_id', $peminatan1->id)
                ->where('status', 'diterima')
                ->count();
            $ranking1 = Alokasi::where('peminatan_id', $peminatan1->id)
                ->where('status', 'diterima')
                ->where('skor_saw', '>', $skor1)
                ->count() + 1;

            $pilihanScores[1] = [
                'peminatan' => $peminatan1,
                'skor' => $skor1,
                'detail' => $this->getDetailSkorSaw($siswa, $siswa->pilihan_peminatan_1),
                'sisa_kursi' => $peminatan1->sisaKursi(),
                'kuota_maksimal' => $peminatan1->kuota_maksimal,
                'terpenuhi' => $peminatan1->sisaKursi() > 0 ? 'Ya' : 'Tidak',
                'ranking' => $ranking1,
                'total_siswa' => $total1
            ];
        }
        if ($siswa->pilihan_peminatan_2) {
            $peminatan2 = Peminatan::find($siswa->pilihan_peminatan_2);
            $skor2 = $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_2);

            // Hitung ranking untuk pilihan 2
            $total2 = Alokasi::where('peminatan_id', $peminatan2->id)
                ->where('status', 'diterima')
                ->count();
            $ranking2 = Alokasi::where('peminatan_id', $peminatan2->id)
                ->where('status', 'diterima')
                ->where('skor_saw', '>', $skor2)
                ->count() + 1;

            $pilihanScores[2] = [
                'peminatan' => $peminatan2,
                'skor' => $skor2,
                'detail' => $this->getDetailSkorSaw($siswa, $siswa->pilihan_peminatan_2),
                'sisa_kursi' => $peminatan2->sisaKursi(),
                'kuota_maksimal' => $peminatan2->kuota_maksimal,
                'terpenuhi' => $peminatan2->sisaKursi() > 0 ? 'Ya' : 'Tidak',
                'ranking' => $ranking2,
                'total_siswa' => $total2
            ];
        }
        if ($siswa->pilihan_peminatan_3) {
            $peminatan3 = Peminatan::find($siswa->pilihan_peminatan_3);
            $skor3 = $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_3);

            // Hitung ranking untuk pilihan 3
            $total3 = Alokasi::where('peminatan_id', $peminatan3->id)
                ->where('status', 'diterima')
                ->count();
            $ranking3 = Alokasi::where('peminatan_id', $peminatan3->id)
                ->where('status', 'diterima')
                ->where('skor_saw', '>', $skor3)
                ->count() + 1;

            $pilihanScores[3] = [
                'peminatan' => $peminatan3,
                'skor' => $skor3,
                'detail' => $this->getDetailSkorSaw($siswa, $siswa->pilihan_peminatan_3),
                'sisa_kursi' => $peminatan3->sisaKursi(),
                'kuota_maksimal' => $peminatan3->kuota_maksimal,
                'terpenuhi' => $peminatan3->sisaKursi() > 0 ? 'Ya' : 'Tidak',
                'ranking' => $ranking3,
                'total_siswa' => $total3
            ];
        }

        // Tentukan alokasi berdasarkan preferensi dan quota
        $alokasiInfo = $this->tentukanAlokasiBerdasarkanPreferensi($siswa);

        return view('admin.siswa.skor-saw.show', compact('alokasi', 'siswa', 'pilihanScores', 'alokasiInfo'));
    }

    /**
     * Edit - Form untuk allocate waitlist ke peminatan
     */
    public function editAlokasi($siswaId)
    {
        $siswa = Siswa::findOrFail($siswaId);
        $peminatans = Peminatan::all();

        // Hitung skor SAW untuk setiap peminatan pilihan
        $skors = [];
        if ($siswa->pilihan_peminatan_1) {
            $skors[1] = $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_1);
        }
        if ($siswa->pilihan_peminatan_2) {
            $skors[2] = $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_2);
        }
        if ($siswa->pilihan_peminatan_3) {
            $skors[3] = $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_3);
        }

        return view('admin.siswa.hasil-seleksi.edit-alokasi', compact('siswa', 'peminatans', 'skors'));
    }

    /**
     * Store - Simpan alokasi untuk waitlist
     */
    public function storeAlokasi(Request $request, $siswaId)
    {
        $request->validate([
            'peminatan_id' => 'required|exists:peminatans,id',
        ]);

        $siswa = Siswa::findOrFail($siswaId);

        // Hitung skor SAW
        $skorSaw = $this->hitungSkorSaw($siswa, $request->peminatan_id);

        // Buat atau update alokasi
        Alokasi::updateOrCreate(
            ['siswa_id' => $siswa->id],
            [
                'peminatan_id' => $request->peminatan_id,
                'skor_saw' => $skorSaw,
                'status' => 'diterima'
            ]
        );

        return redirect()->route('admin.siswa.hasil-seleksi')
            ->with('success', "Alokasi untuk {$siswa->nama} berhasil disimpan");
    }

    /**
     * Private function untuk hitung skor SAW
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

        return $totalSkor;
    }

    /**
     * Get detail perhitungan skor SAW untuk transparansi
     */
    private function getDetailSkorSaw($siswa, $peminatanId)
    {
        $kriterias = Kriteria::where('peminatan_id', $peminatanId)->get();
        $details = [];

        if ($kriterias->isEmpty()) {
            return $details;
        }

        foreach ($kriterias as $kriteria) {
            $nilai = $siswa->{'nilai_' . $kriteria->mapel} ?? 0;

            // Cari nilai maksimum dari SEMUA siswa
            $maxNilai = Siswa::whereNotNull('nilai_' . $kriteria->mapel)
                ->max('nilai_' . $kriteria->mapel);

            if ($maxNilai === null || $maxNilai == 0) {
                $maxNilai = 100;
            }

            $normalisasi = $nilai / $maxNilai;
            $skorKriteria = $kriteria->bobot * $normalisasi;

            $details[] = [
                'mapel' => ucfirst($kriteria->mapel),
                'nilai' => $nilai,
                'max_nilai' => $maxNilai,
                'bobot' => $kriteria->bobot,
                'normalisasi' => $normalisasi,
                'skor' => $skorKriteria
            ];
        }

        return $details;
    }

    /**
     * Tentukan alokasi berdasarkan preferensi pilihan dan quota
     * Logika: Pilihan 1 → Pilihan 2 → Pilihan 3 → Waitlist
     */
    private function tentukanAlokasiBerdasarkanPreferensi($siswa)
    {
        $pilihans = [
            1 => $siswa->pilihan_peminatan_1,
            2 => $siswa->pilihan_peminatan_2,
            3 => $siswa->pilihan_peminatan_3,
        ];

        $skorPilihans = [];

        // Hitung skor untuk setiap pilihan
        foreach ($pilihans as $no => $peminatanId) {
            if ($peminatanId) {
                $skor = $this->hitungSkorSaw($siswa, $peminatanId);
                $peminatan = Peminatan::find($peminatanId);
                $skorPilihans[$no] = [
                    'peminatan_id' => $peminatanId,
                    'peminatan' => $peminatan,
                    'skor' => $skor,
                    'sisa_kursi' => $peminatan->sisaKursi()
                ];
            }
        }

        // Urutkan berdasarkan skor tertinggi
        usort($skorPilihans, function ($a, $b) {
            return $b['skor'] <=> $a['skor'];
        });

        // Cek pilihan berdasarkan urutan skor, jika ada quota
        foreach ($skorPilihans as $alokasi) {
            if ($alokasi['sisa_kursi'] > 0) {
                // Ada kursi tersedia
                return [
                    'peminatan_id' => $alokasi['peminatan_id'],
                    'skor_saw' => $alokasi['skor'],
                    'status' => 'diterima',
                    'alasan' => "Diterima di {$alokasi['peminatan']->nama} dengan skor {$alokasi['skor']}"
                ];
            }
        }

        // Jika semua peminatan penuh atau tidak ada skor, masuk waitlist
        // Ambil skor tertinggi untuk waitlist
        $skorTertinggi = 0;
        $peminatanWaitlist = null;
        foreach ($skorPilihans as $alokasi) {
            if ($alokasi['skor'] > $skorTertinggi) {
                $skorTertinggi = $alokasi['skor'];
                $peminatanWaitlist = $alokasi['peminatan_id'];
            }
        }

        if ($peminatanWaitlist) {
            return [
                'peminatan_id' => $peminatanWaitlist,
                'skor_saw' => $skorTertinggi,
                'status' => 'waitlist',
                'alasan' => "Semua pilihan peminatan penuh, masuk waitlist"
            ];
        }

        // Fallback jika tidak ada pilihan
        return [
            'peminatan_id' => null,
            'skor_saw' => 0,
            'status' => 'ditolak',
            'alasan' => "Tidak ada pilihan peminatan"
        ];
    }

    /**
     * Tampilkan siswa yang belum dialokasikan untuk alokasi manual
     */
    public function siswaBelumditerima()
    {
        // Cari siswa yang belum punya alokasi
        $siswaBelumDiterima = Siswa::with('pilihanPeminatan1', 'pilihanPeminatan2', 'pilihanPeminatan3')
            ->doesntHave('alokasi')
            ->orderBy('nis')
            ->paginate(15);

        return view('admin.siswa.hasil-seleksi.belum-diterima', compact('siswaBelumDiterima'));
    }

    /**
     * Simpan alokasi manual siswa ke PAKET 6
     */
    public function simpanAlokasiManual(Request $request)
    {
        $validated = $request->validate([
            'siswa_ids' => 'required|array|min:1',
            'siswa_ids.*' => 'exists:siswas,id',
        ]);

        $peminatan6 = Peminatan::find(6); // PAKET 6

        foreach ($validated['siswa_ids'] as $siswaId) {
            $siswa = Siswa::find($siswaId);

            // Hitung skor SAW untuk pilihan 1
            $skorSaw = $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_1);

            // Buat alokasi
            Alokasi::create([
                'siswa_id' => $siswaId,
                'peminatan_id' => 6,
                'skor_saw' => $skorSaw,
                'status' => 'diterima',
                'catatan' => 'Alokasi manual oleh admin'
            ]);
        }

        return redirect()->route('admin.siswa.hasil-seleksi')
            ->with('success', count($validated['siswa_ids']) . ' siswa berhasil dialokasikan ke PAKET 6!');
    }

    /**
     * Allocate ALL waitlist siswa ke PAKET 6
     */
    public function allocateAllWaitlist()
    {
        // Ambil semua siswa waitlist dengan eager loading
        /** @var \Illuminate\Database\Eloquent\Collection $waitlistAlokas */
        $waitlistAlokas = Alokasi::where('status', 'waitlist')->with('siswa')->get();

        $count = 0;
        foreach ($waitlistAlokas as $alokasi) {
            if (!$alokasi || !$alokasi->siswa) {
                continue;
            }

            $siswa = $alokasi->siswa;

            // Hitung skor SAW untuk pilihan 1
            $skorSaw = $this->hitungSkorSaw($siswa, $siswa->pilihan_peminatan_1);

            // Update alokasi ke PAKET 6
            /** @var Alokasi $alokasi */
            $alokasi->update([
                'peminatan_id' => 6,
                'skor_saw' => $skorSaw,
                'status' => 'diterima',
                'catatan' => 'Alokasi ke PAKET 6 (bulk allocate by admin)'
            ]);

            $count++;
        }

        return redirect()->route('admin.siswa.hasil-seleksi')
            ->with('success', $count . ' siswa waitlist berhasil dialokasikan ke PAKET 6!');
    }
}
