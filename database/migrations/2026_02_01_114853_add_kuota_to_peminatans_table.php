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
        Schema::table('peminatans', function (Blueprint $table) {
            $table->integer('kuota')->default(0)->after('kuota_maksimal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminatans', function (Blueprint $table) {
            $table->dropColumn('kuota');
        });
    }
};
