<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Alokasi;

class UpdateAllocationStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alokasi:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status alokasi berdasarkan skor SAW (Diterima/Waitlist/Ditolak)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Mengupdate status alokasi...');

        // Logika: Semua yang ada di alokasi = DITERIMA
        // Karena alokasi adalah hasil dari proses SAW yang berhasil

        $totalAlokasi = Alokasi::count();

        if ($totalAlokasi === 0) {
            $this->warn('⚠️ Tidak ada data alokasi');
            return Command::FAILURE;
        }

        // Update semua alokasi menjadi "diterima"
        Alokasi::query()->update(['status' => 'diterima']);

        $this->info("✅ Update selesai!");
        $this->info("   📊 Semua alokasi (diterima): $totalAlokasi");

        return Command::SUCCESS;
    }
}
