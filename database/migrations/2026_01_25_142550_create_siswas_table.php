<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nis')->unique();
            $table->string('kelas_asal')->nullable();
            $table->decimal('nilai_matematika', 5, 2)->nullable();
            $table->decimal('nilai_fisika', 5, 2)->nullable();
            $table->decimal('nilai_kimia', 5, 2)->nullable();
            $table->decimal('nilai_biologi', 5, 2)->nullable();
            $table->decimal('nilai_tik', 5, 2)->nullable();
            $table->decimal('nilai_binggris', 5, 2)->nullable();
            $table->decimal('nilai_sosiologi', 5, 2)->nullable();
            $table->decimal('nilai_ekonomi', 5, 2)->nullable();
            $table->decimal('nilai_geografi', 5, 2)->nullable();
            
            // ✅ TAMBAHKAN KOLOM PILIHAN PEMINATAN INI
            $table->unsignedBigInteger('pilihan_peminatan_1')->nullable();
            $table->unsignedBigInteger('pilihan_peminatan_2')->nullable();
            $table->unsignedBigInteger('pilihan_peminatan_3')->nullable();
            
            $table->string('file_raport')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('siswas');
    }
};