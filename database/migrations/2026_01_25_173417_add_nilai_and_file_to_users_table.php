<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
                    // Kolom nilai
        $table->decimal('nilai_matematika', 5, 2)->nullable();
        $table->decimal('nilai_fisika', 5, 2)->nullable();
        $table->decimal('nilai_kimia', 5, 2)->nullable();
        $table->decimal('nilai_biologi', 5, 2)->nullable();
        $table->decimal('nilai_tik', 5, 2)->nullable();
        $table->decimal('nilai_binggris', 5, 2)->nullable();
        $table->decimal('nilai_sosiologi', 5, 2)->nullable();
        $table->decimal('nilai_ekonomi', 5, 2)->nullable();
        $table->decimal('nilai_geografi', 5, 2)->nullable();
        
        // Kolom file raport
        $table->string('file_raport')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
