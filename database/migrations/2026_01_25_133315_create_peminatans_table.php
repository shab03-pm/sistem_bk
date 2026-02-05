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
        Schema::create('peminatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('kuota_maksimal');
            $table->timestamps();
            $table->unsignedBigInteger('pilihan_peminatan_1')->nullable();
            $table->unsignedBigInteger('pilihan_peminatan_2')->nullable();
            $table->unsignedBigInteger('pilihan_peminatan_3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminatans');
    }
};
