<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Siswa;
use App\Exports\System3AllocationExport;
use Maatwebsite\Excel\Facades\Excel;

class TestExportPilihan extends Command
{
    protected $signature = 'test:export-pilihan';
    protected $description = 'Test export dengan check pilihan';

    public function handle()
    {
        $this->info('Testing pilihan data...');

        $siswa = Siswa::with('pilihanPeminatan1', 'pilihanPeminatan2', 'pilihanPeminatan3')->first();

        if (!$siswa) {
            $this->error('No siswa found');
            return;
        }

        $this->line("NIS: {$siswa->nis}");
        $this->line("P1 ID: {$siswa->pilihan_peminatan_1}");
        $this->line("P1 Nama: " . ($siswa->pilihanPeminatan1?->nama ?? 'NULL'));
        $this->line("P2 ID: {$siswa->pilihan_peminatan_2}");
        $this->line("P2 Nama: " . ($siswa->pilihanPeminatan2?->nama ?? 'NULL'));
        $this->line("P3 ID: {$siswa->pilihan_peminatan_3}");
        $this->line("P3 Nama: " . ($siswa->pilihanPeminatan3?->nama ?? 'NULL'));

        $this->info('\nGenerating export...');
        $fileName = 'test_pilihan_' . date('YmdHis') . '.xlsx';
        Excel::store(new System3AllocationExport(), $fileName, 'public');
        $this->info("✓ Export generated: storage/app/public/{$fileName}");
    }
}
