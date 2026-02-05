<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Peminatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaSeederController extends Controller
{
    /**
     * Show form untuk generate siswa
     */
    public function form()
    {
        $peminatans = Peminatan::all();
        return view('siswa-seeder.form', compact('peminatans'));
    }

    /**
     * Generate siswa berdasarkan parameter
     */
    public function generate(Request $request)
    {
        $jumlahKelas = $request->input('jumlah_kelas', 11);
        $siswaPerKelas = $request->input('siswa_per_kelas', 36);
        $deleteExisting = $request->input('delete_existing', false);

        // Hapus siswa existing jika dicentang
        if ($deleteExisting) {
            Siswa::truncate();
        }

        $peminatans = Peminatan::all();
        $kelasDaftar = [];
        for ($i = 1; $i <= $jumlahKelas; $i++) {
            $kelasDaftar[] = "X MERDEKA " . $i;
        }

        $totalSiswa = $jumlahKelas * $siswaPerKelas;
        $nisStart = 10001;
        $created = 0;
        $errors = [];

        try {
            for ($k = 0; $k < $jumlahKelas; $k++) {
                $kelas = $kelasDaftar[$k];

                for ($s = 0; $s < $siswaPerKelas; $s++) {
                    $nis = $nisStart + ($k * $siswaPerKelas) + $s;

                    // Random pilihan peminatan (indeks 1-7, bisa repeat)
                    $pilihan1 = $peminatans->random()->id;
                    $pilihan2 = $peminatans->random()->id;
                    $pilihan3 = $peminatans->random()->id;

                    // Generate nilai 70-100 untuk setiap mapel
                    $nilaiMapel = [
                        'nilai_matematika' => rand(70, 100),
                        'nilai_fisika' => rand(70, 100),
                        'nilai_kimia' => rand(70, 100),
                        'nilai_biologi' => rand(70, 100),
                        'nilai_tik' => rand(70, 100),
                        'nilai_binggris' => rand(70, 100),
                        'nilai_sosiologi' => rand(70, 100),
                        'nilai_ekonomi' => rand(70, 100),
                        'nilai_geografi' => rand(70, 100),
                    ];

                    try {
                        Siswa::create([
                            'nis' => $nis,
                            'nama' => 'Siswa ' . $nis,
                            'kelas_asal' => $kelas,
                            'pilihan_peminatan_1' => $pilihan1,
                            'pilihan_peminatan_2' => $pilihan2,
                            'pilihan_peminatan_3' => $pilihan3,
                            'email' => 'siswa' . $nis . '@sekolah.local',
                            'password' => Hash::make('password123'),
                            'file_raport' => null,
                            ...$nilaiMapel,
                        ]);
                        $created++;
                    } catch (\Exception $e) {
                        $errors[] = "Gagal membuat siswa NIS $nis: " . $e->getMessage();
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Berhasil membuat $created dari $totalSiswa siswa",
                'created' => $created,
                'total' => $totalSiswa,
                'errors' => $errors,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
