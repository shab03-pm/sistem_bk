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
       Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('kelas');
            $table->integer('matematika');
            $table->integer('fisika');
            $table->integer('kimia');
            $table->integer('biologi');
            $table->integer('tik');
            $table->integer('bahasa_inggris');
            $table->integer('sosiologi');
            $table->integer('geografi');
            $table->integer('ekonomi');
            $table->string('rapor_file');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
