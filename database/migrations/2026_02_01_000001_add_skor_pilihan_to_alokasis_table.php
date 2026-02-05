<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('alokasis', function (Blueprint $table) {
            // Tambah kolom skor per pilihan jika belum ada
            if (!Schema::hasColumn('alokasis', 'skor_pilihan_1')) {
                $table->decimal('skor_pilihan_1', 8, 4)->nullable()->after('skor_saw');
                $table->decimal('skor_pilihan_2', 8, 4)->nullable()->after('skor_pilihan_1');
                $table->decimal('skor_pilihan_3', 8, 4)->nullable()->after('skor_pilihan_2');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alokasis', function (Blueprint $table) {
            if (Schema::hasColumn('alokasis', 'skor_pilihan_1')) {
                $table->dropColumn('skor_pilihan_1');
                $table->dropColumn('skor_pilihan_2');
                $table->dropColumn('skor_pilihan_3');
            }
        });
    }
};
