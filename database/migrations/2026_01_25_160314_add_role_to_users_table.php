<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Hanya tambahkan kolom 'role' jika belum ada
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('siswa');
            }
            
            // Jika ingin menambahkan kolom lain, cek dulu
            // if (!Schema::hasColumn('users', 'nis')) {
            //     $table->string('nis')->nullable();
            // }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};