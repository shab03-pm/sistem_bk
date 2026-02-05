<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kriterias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peminatan_id');
            $table->string('mapel'); // matematika, fisika, kimia, dll
            $table->decimal('bobot', 3, 2); // contoh: 0.25
            $table->timestamps();

            $table->foreign('peminatan_id')->references('id')->on('peminatans')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kriterias');
    }
};