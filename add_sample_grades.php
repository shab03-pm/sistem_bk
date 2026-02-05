<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Siswa;

// Get all siswa
$siswas = Siswa::all();

echo "Menambahkan nilai raport untuk " . count($siswas) . " siswa...\n";

foreach ($siswas as $siswa) {
    // Generate random grades between 70-100
    $siswa->update([
        'nilai_matematika' => rand(70, 100),
        'nilai_fisika' => rand(70, 100),
        'nilai_kimia' => rand(70, 100),
        'nilai_biologi' => rand(70, 100),
        'nilai_tik' => rand(70, 100),
        'nilai_binggris' => rand(70, 100),
        'nilai_sosiologi' => rand(70, 100),
        'nilai_ekonomi' => rand(70, 100),
        'nilai_geografi' => rand(70, 100),
    ]);

    echo "✓ Updated: {$siswa->nama} ({$siswa->nis})\n";
}

echo "\n✓ Selesai! Nilai raport berhasil ditambahkan.\n";
