<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Exports\System3AllocationExport;
use Maatwebsite\Excel\Facades\Excel;

class TestExportCommand extends Command
{
    protected $signature = 'export:test';
    protected $description = 'Test generate Excel export System 3';

    public function handle()
    {
        $this->info('🔄 Testing Excel export generation...');

        try {
            $export = new System3AllocationExport();
            $filename = 'test_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

            // Store to public disk
            Excel::store($export, $filename, 'public');

            $this->info('✅ File export berhasil dibuat!');
            $this->info('📁 File: ' . $filename);
            $this->info('📍 Path: storage/app/public/' . $filename);

            // Show sheet info
            $sheets = $export->sheets();
            $this->info("\n📊 Total Sheets: " . count($sheets));

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            $this->error('Stack: ' . $e->getTraceAsString());
            return Command::FAILURE;
        }
    }
}
