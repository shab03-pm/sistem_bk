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
        Schema::create('alokasis', function (Blueprint $table) {
     $table->id();
    $table->unsignedBigInteger('siswa_id');
    $table->unsignedBigInteger('peminatan_id');
    $table->decimal('skor_saw', 8, 4);
    $table->timestamps();

    // Foreign key constraints
    $table->foreign('siswa_id')->references('id')->on('siswas')->onDelete('cascade');
    $table->foreign('peminatan_id')->references('id')->on('peminatans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alokasis');
    }
};
