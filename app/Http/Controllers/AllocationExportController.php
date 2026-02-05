<?php

namespace App\Http\Controllers;

use App\Exports\System3AllocationExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class AllocationExportController extends Controller
{
    /**
     * Export hasil alokasi System 3 ke Excel
     * - Sheet 1: Ringkasan per peminatan
     * - Sheets 2-8: Detail per PAKET dengan skor breakdown
     * - Sheet 9: Waiting List
     */
    public function exportExcel()
    {
        $filename = 'Hasil_Alokasi_System3_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new System3AllocationExport(), $filename);
    }
}
