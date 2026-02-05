<?php

namespace App\Http\Controllers;

use App\Models\Peminatan;
use App\Models\Alokasi;
use App\Models\Kriteria;
use App\Models\Siswa; // ✅ Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SiswaController extends Controller
{
    public function showInputNilai()
    {
        $siswa = Siswa::where('nis', auth()->user()->nis)->first();
        return view('siswa.input-nilai-raport.index', compact('siswa'));
    }

    // ✅ METHOD INI HANYA SATU KALI
    public function updateNilai(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nilai_matematika' => 'required|numeric|min:0|max:100',
                'nilai_fisika' => 'required|numeric|min:0|max:100',
                'nilai_kimia' => 'required|numeric|min:0|max:100',
                'nilai_biologi' => 'required|numeric|min:0|max:100',
                'nilai_tik' => 'required|numeric|min:0|max:100',
                'nilai_binggris' => 'required|numeric|min:0|max:100',
                'nilai_sosiologi' => 'required|numeric|min:0|max:100',
                'nilai_ekonomi' => 'required|numeric|min:0|max:100',
                'nilai_geografi' => 'required|numeric|min:0|max:100',
                'file_raport' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            ], [
                'nilai_matematika.required' => 'Nilai Matematika wajib diisi.',
                'nilai_matematika.numeric' => 'Nilai Matematika harus berupa angka.',
                'nilai_matematika.min' => 'Nilai minimal 0.',
                'nilai_matematika.max' => 'Nilai maksimal 100.',

                'nilai_fisika.required' => 'Nilai Fisika wajib diisi.',
                'nilai_fisika.numeric' => 'Nilai Fisika harus berupa angka.',
                'nilai_fisika.min' => 'Nilai minimal 0.',
                'nilai_fisika.max' => 'Nilai maksimal 100.',

                'nilai_kimia.required' => 'Nilai Kimia wajib diisi.',
                'nilai_kimia.numeric' => 'Nilai Kimia harus berupa angka.',
                'nilai_kimia.min' => 'Nilai minimal 0.',
                'nilai_kimia.max' => 'Nilai maksimal 100.',

                'nilai_biologi.required' => 'Nilai Biologi wajib diisi.',
                'nilai_biologi.numeric' => 'Nilai Biologi harus berupa angka.',
                'nilai_biologi.min' => 'Nilai minimal 0.',
                'nilai_biologi.max' => 'Nilai maksimal 100.',

                'nilai_tik.required' => 'Nilai TIK wajib diisi.',
                'nilai_tik.numeric' => 'Nilai TIK harus berupa angka.',
                'nilai_tik.min' => 'Nilai minimal 0.',
                'nilai_tik.max' => 'Nilai maksimal 100.',

                'nilai_binggris.required' => 'Nilai Bahasa Inggris wajib diisi.',
                'nilai_binggris.numeric' => 'Nilai Bahasa Inggris harus berupa angka.',
                'nilai_binggris.min' => 'Nilai minimal 0.',
                'nilai_binggris.max' => 'Nilai maksimal 100.',

                'nilai_sosiologi.required' => 'Nilai Sosiologi wajib diisi.',
                'nilai_sosiologi.numeric' => 'Nilai Sosiologi harus berupa angka.',
                'nilai_sosiologi.min' => 'Nilai minimal 0.',
                'nilai_sosiologi.max' => 'Nilai maksimal 100.',

                'nilai_ekonomi.required' => 'Nilai Ekonomi wajib diisi.',
                'nilai_ekonomi.numeric' => 'Nilai Ekonomi harus berupa angka.',
                'nilai_ekonomi.min' => 'Nilai minimal 0.',
                'nilai_ekonomi.max' => 'Nilai maksimal 100.',

                'nilai_geografi.required' => 'Nilai Geografi wajib diisi.',
                'nilai_geografi.numeric' => 'Nilai Geografi harus berupa angka.',
                'nilai_geografi.min' => 'Nilai minimal 0.',
                'nilai_geografi.max' => 'Nilai maksimal 100.',

                'file_raport.mimes' => 'File harus berupa PDF, JPG, JPEG, atau PNG.',
                'file_raport.max' => 'Ukuran file maksimal 5MB.',
            ]);

            Log::info('Validasi berhasil, data:', $validatedData);

            // Siapkan data dasar
            $dataToSave = [
                'nama' => auth()->user()->name,
                'nis' => auth()->user()->nis,
                'kelas_asal' => auth()->user()->kelas_asal ?? null,
                'nilai_matematika' => $validatedData['nilai_matematika'],
                'nilai_fisika' => $validatedData['nilai_fisika'],
                'nilai_kimia' => $validatedData['nilai_kimia'],
                'nilai_biologi' => $validatedData['nilai_biologi'],
                'nilai_tik' => $validatedData['nilai_tik'],
                'nilai_binggris' => $validatedData['nilai_binggris'],
                'nilai_sosiologi' => $validatedData['nilai_sosiologi'],
                'nilai_ekonomi' => $validatedData['nilai_ekonomi'],
                'nilai_geografi' => $validatedData['nilai_geografi'],
            ];

            // Handle upload file
            $fileName = null;
            if ($request->hasFile('file_raport')) {
                $siswaExisting = Siswa::where('nis', auth()->user()->nis)->first();

                // Hapus file lama jika ada
                if ($siswaExisting && $siswaExisting->file_raport) {
                    Storage::disk('public')->delete('raport/' . $siswaExisting->file_raport);
                }

                // Simpan file baru
                $fileName = 'raport_' . ($siswaExisting ? $siswaExisting->id : time()) . '_' . time() . '.' . $request->file('file_raport')->extension();
                $request->file('file_raport')->storeAs('raport', $fileName, 'public');
            }

            // Tambahkan file_raport ke data (jika tidak ada upload, biarkan null)
            $dataToSave['file_raport'] = $fileName;

            // Update atau create
            $siswa = Siswa::updateOrCreate(
                ['nis' => auth()->user()->nis],
                $dataToSave
            );

            Log::info('Data berhasil disimpan untuk siswa ID:', [$siswa->id]);

            return redirect()->route('siswa.dashboard')
                ->with('success', 'Nilai raport berhasil disimpan!');

        } catch (\Exception $e) {
            Log::error('Error saat menyimpan nilai: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.']);
        }
    }

    // ✅ FITUR BARU: Pilih Peminatan
    public function showPilihPeminatan()
    {
        $peminatans = Peminatan::all();
        return view('siswa.pilih-peminatan.index', compact('peminatans'));
    }

    public function simpanPilihan(Request $request)
    {
        try {
            $request->validate([
                'pilihan_1' => 'required|exists:peminatans,id',
                'pilihan_2' => [
                    'required',
                    'exists:peminatans,id',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value == $request->pilihan_1) {
                            $fail('Pilihan kedua tidak boleh sama dengan pilihan pertama.');
                        }
                    }
                ],
                'pilihan_3' => [
                    'required',
                    'exists:peminatans,id',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value == $request->pilihan_1 || $value == $request->pilihan_2) {
                            $fail('Pilihan ketiga tidak boleh sama dengan pilihan sebelumnya.');
                        }
                    }
                ],
            ], [
                'pilihan_1.required' => 'Pilihan pertama wajib diisi.',
                'pilihan_1.exists' => 'Pilihan pertama tidak valid.',
                'pilihan_2.required' => 'Pilihan kedua wajib diisi.',
                'pilihan_2.exists' => 'Pilihan kedua tidak valid.',
                'pilihan_3.required' => 'Pilihan ketiga wajib diisi.',
                'pilihan_3.exists' => 'Pilihan ketiga tidak valid.',
            ]);

            // Simpan ke tabel siswas
            $siswa = Siswa::where('nis', auth()->user()->nis)->first();
            if ($siswa) {
                $siswa->update([
                    'pilihan_peminatan_1' => $request->pilihan_1,
                    'pilihan_peminatan_2' => $request->pilihan_2,
                    'pilihan_peminatan_3' => $request->pilihan_3,
                ]);
            }

            Log::info('Pilihan peminatan disimpan untuk user NIS:', [auth()->user()->nis]);

            return redirect()->route('siswa.dashboard')
                ->with('success', 'Pilihan peminatan berhasil disimpan!');

        } catch (\Exception $e) {
            Log::error('Error saat menyimpan pilihan: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan pilihan. Silakan coba lagi.']);
        }
    }

    // ✅ FITUR BARU: Hasil Seleksi
    public function hasilSeleksi()
    {
        // Ambil dari tabel alokasis yang relasi ke siswas
        $alokasi = Alokasi::whereHas('siswa', function ($q) {
            $q->where('nis', auth()->user()->nis);
        })->with(['peminatan.kriterias', 'siswa.pilihanPeminatan1', 'siswa.pilihanPeminatan2', 'siswa.pilihanPeminatan3'])->first();

        // Hitung ranking siswa di peminatan yang diterima
        $ranking = null;
        $totalSiswa = null;
        if ($alokasi) {
            $totalSiswa = Alokasi::where('peminatan_id', $alokasi->peminatan_id)
                ->where('status', 'diterima')
                ->count();

            $ranking = Alokasi::where('peminatan_id', $alokasi->peminatan_id)
                ->where('status', 'diterima')
                ->where('skor_saw', '>', $alokasi->skor_saw)
                ->count() + 1;
        }

        return view('siswa.hasil-seleksi.index', compact('alokasi', 'ranking', 'totalSiswa'));
    }

    // ✅ FITUR BARU: Skor SAW
    public function skorSaw()
    {
        $alokasi = Alokasi::whereHas('siswa', function ($q) {
            $q->where('nis', auth()->user()->nis);
        })->with(['peminatan.kriterias', 'siswa.pilihanPeminatan1', 'siswa.pilihanPeminatan2', 'siswa.pilihanPeminatan3'])->first();

        $detailSkorPerPilihan = [];

        if ($alokasi) {
            $siswa = $alokasi->siswa;

            // Array untuk ketiga pilihan
            $pilihans = [
                1 => ['id' => $siswa->pilihan_peminatan_1, 'peminatan' => $siswa->pilihanPeminatan1],
                2 => ['id' => $siswa->pilihan_peminatan_2, 'peminatan' => $siswa->pilihanPeminatan2],
                3 => ['id' => $siswa->pilihan_peminatan_3, 'peminatan' => $siswa->pilihanPeminatan3],
            ];

            foreach ($pilihans as $noPilihan => $pilihan) {
                if (!$pilihan['peminatan'])
                    continue;

                $peminatan = $pilihan['peminatan'];
                $kriterias = $peminatan->kriterias ?? [];
                $detailSkor = [];
                $totalSkor = 0;

                foreach ($kriterias as $kriteria) {
                    $fieldName = 'nilai_' . strtolower(trim($kriteria->mapel));
                    $nilai = $siswa->{$fieldName} ?? 0;

                    $maxNilai = Siswa::whereNotNull($fieldName)->max($fieldName);
                    $normalisasi = $maxNilai > 0 ? $nilai / $maxNilai : 0;
                    $kontribusi = $kriteria->bobot * $normalisasi;
                    $totalSkor += $kontribusi;

                    $detailSkor[] = [
                        'mapel' => $kriteria->mapel,
                        'nilai' => $nilai,
                        'nilai_maksimum' => $maxNilai,
                        'bobot' => $kriteria->bobot,
                        'normalisasi' => $normalisasi,
                        'kontribusi' => $kontribusi
                    ];
                }

                // Hitung ranking untuk pilihan ini
                $totalSiswa = Alokasi::where('peminatan_id', $peminatan->id)
                    ->where('status', 'diterima')
                    ->count();

                $ranking = Alokasi::where('peminatan_id', $peminatan->id)
                    ->where('status', 'diterima')
                    ->where('skor_saw', '>', $totalSkor)
                    ->count() + 1;

                $isDiterima = $alokasi->peminatan_id == $peminatan->id;

                $detailSkorPerPilihan[$noPilihan] = [
                    'peminatan' => $peminatan,
                    'skor' => $totalSkor,
                    'ranking' => $ranking,
                    'totalSiswa' => $totalSiswa,
                    'isDiterima' => $isDiterima,
                    'detail' => $detailSkor
                ];
            }
        }

        return view('siswa.skor-saw.index', compact('alokasi', 'detailSkorPerPilihan'));
    }

    // ✅ Update Profile Siswa - SIMPAN KE TABEL SISWAS SAJA
    public function updateProfile(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'nis' => 'required|string|max:20',
            'email' => 'required|email|unique:siswas,email,' . auth()->user()->nis . ',nis',
            'kelas_asal' => 'required|string|max:100',
        ];

        // Validasi password hanya jika ada input
        if ($request->filled('password')) {
            $rules['password'] = 'required|min:8';
            $rules['password_confirmation'] = 'required|same:password';
        }

        $request->validate($rules);

        // Siapkan data update untuk tabel siswas
        $dataToUpdate = [
            'nama' => $request->name,
            'nis' => $request->nis,
            'email' => $request->email,
            'kelas_asal' => $request->kelas_asal
        ];

        // Hash password jika diisi dan simpan ke siswas
        if ($request->filled('password')) {
            $dataToUpdate['password'] = bcrypt($request->password);
        }

        // Update hanya di tabel siswas (tidak update tabel users)
        Siswa::where('nis', auth()->user()->nis)->update($dataToUpdate);

        // Update email di tabel users agar tetap konsisten dengan login
        if ($request->email !== auth()->user()->email) {
            auth()->user()->update(['email' => $request->email]);
        }

        return redirect()->route('siswa.profile')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    // Tambahan: method untuk menampilkan halaman profil
    public function showProfile()
    {
        $siswa = Siswa::where('nis', auth()->user()->nis)->first();
        return view('siswa.profile', compact('siswa'));
    }
}