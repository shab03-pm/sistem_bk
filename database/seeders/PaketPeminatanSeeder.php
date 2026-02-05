<?php

namespace Database\Seeders;

use App\Models\Peminatan;
use App\Models\Kriteria;
use Illuminate\Database\Seeder;

class PaketPeminatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Paket 1: Matematika, Fisika, Kimia, Biologi - Kuota 72
        $paket1 = Peminatan::create([
            'nama' => 'PAKET 1 (MATEMATIKA, FISIKA, KIMIA, BIOLOGI)',
            'kuota_maksimal' => 72,
        ]);
        Kriteria::create(['peminatan_id' => $paket1->id, 'mapel' => 'matematika', 'bobot' => 0.30]);
        Kriteria::create(['peminatan_id' => $paket1->id, 'mapel' => 'fisika', 'bobot' => 0.30]);
        Kriteria::create(['peminatan_id' => $paket1->id, 'mapel' => 'kimia', 'bobot' => 0.20]);
        Kriteria::create(['peminatan_id' => $paket1->id, 'mapel' => 'biologi', 'bobot' => 0.20]);

        // Paket 2: Matematika, Fisika, Kimia, TIK - Kuota 36
        $paket2 = Peminatan::create([
            'nama' => 'PAKET 2 (MATEMATIKA,FISIKA,KIMIA,TIK)',
            'kuota_maksimal' => 36,
        ]);
        Kriteria::create(['peminatan_id' => $paket2->id, 'mapel' => 'matematika', 'bobot' => 0.30]);
        Kriteria::create(['peminatan_id' => $paket2->id, 'mapel' => 'fisika', 'bobot' => 0.30]);
        Kriteria::create(['peminatan_id' => $paket2->id, 'mapel' => 'kimia', 'bobot' => 0.20]);
        Kriteria::create(['peminatan_id' => $paket2->id, 'mapel' => 'tik', 'bobot' => 0.20]);

        // Paket 3: Matematika, Fisika, Kimia, B.Inggris - Kuota 36
        $paket3 = Peminatan::create([
            'nama' => 'PAKET 3 (MATEMATIKA,FISIKA,KIMIA,B.INGGRIS)',
            'kuota_maksimal' => 36,
        ]);
        Kriteria::create(['peminatan_id' => $paket3->id, 'mapel' => 'matematika', 'bobot' => 0.30]);
        Kriteria::create(['peminatan_id' => $paket3->id, 'mapel' => 'fisika', 'bobot' => 0.30]);
        Kriteria::create(['peminatan_id' => $paket3->id, 'mapel' => 'kimia', 'bobot' => 0.20]);
        Kriteria::create(['peminatan_id' => $paket3->id, 'mapel' => 'binggris', 'bobot' => 0.20]);

        // Paket 4: Matematika, Fisika, Kimia, Sosiologi - Kuota 36
        $paket4 = Peminatan::create([
            'nama' => 'PAKET 4 (MATEMATIKA,FISIKA,KIMIA,SOSIOLOGI)',
            'kuota_maksimal' => 36,
        ]);
        Kriteria::create(['peminatan_id' => $paket4->id, 'mapel' => 'matematika', 'bobot' => 0.30]);
        Kriteria::create(['peminatan_id' => $paket4->id, 'mapel' => 'fisika', 'bobot' => 0.30]);
        Kriteria::create(['peminatan_id' => $paket4->id, 'mapel' => 'kimia', 'bobot' => 0.20]);
        Kriteria::create(['peminatan_id' => $paket4->id, 'mapel' => 'sosiologi', 'bobot' => 0.20]);

        // Paket 5: Matematika, Ekonomi, Sosiologi, Biologi - Kuota 72
        $paket5 = Peminatan::create([
            'nama' => 'PAKET 5 (MATEMATIKA,EKONOMI,SOSIOLOGI,BIOLOGI)',
            'kuota_maksimal' => 72,
        ]);
        Kriteria::create(['peminatan_id' => $paket5->id, 'mapel' => 'matematika', 'bobot' => 0.30]);
        Kriteria::create(['peminatan_id' => $paket5->id, 'mapel' => 'ekonomi', 'bobot' => 0.30]);
        Kriteria::create(['peminatan_id' => $paket5->id, 'mapel' => 'sosiologi', 'bobot' => 0.20]);
        Kriteria::create(['peminatan_id' => $paket5->id, 'mapel' => 'biologi', 'bobot' => 0.20]);

        // Paket 6: Geografi, Ekonomi, Sosiologi, TIK - Kuota 108
        $paket6 = Peminatan::create([
            'nama' => 'PAKET 6 (GEOGRAFI,EKONOMI,SOSIOLOGI,TIK)',
            'kuota_maksimal' => 108,
        ]);
        Kriteria::create(['peminatan_id' => $paket6->id, 'mapel' => 'geografi', 'bobot' => 0.30]);
        Kriteria::create(['peminatan_id' => $paket6->id, 'mapel' => 'ekonomi', 'bobot' => 0.30]);
        Kriteria::create(['peminatan_id' => $paket6->id, 'mapel' => 'sosiologi', 'bobot' => 0.20]);
        Kriteria::create(['peminatan_id' => $paket6->id, 'mapel' => 'tik', 'bobot' => 0.20]);

        // Paket 7: Geografi, Ekonomi, Sosiologi, B.Inggris - Kuota 36
        $paket7 = Peminatan::create([
            'nama' => 'PAKET 7 (GEOFRAFI,EKONOMI,SOSIOLOGI,B.INGGRIS)',
            'kuota_maksimal' => 36,
        ]);
        Kriteria::create(['peminatan_id' => $paket7->id, 'mapel' => 'geografi', 'bobot' => 0.30]);
        Kriteria::create(['peminatan_id' => $paket7->id, 'mapel' => 'ekonomi', 'bobot' => 0.30]);
        Kriteria::create(['peminatan_id' => $paket7->id, 'mapel' => 'sosiologi', 'bobot' => 0.20]);
        Kriteria::create(['peminatan_id' => $paket7->id, 'mapel' => 'binggris', 'bobot' => 0.20]);
    }
}
