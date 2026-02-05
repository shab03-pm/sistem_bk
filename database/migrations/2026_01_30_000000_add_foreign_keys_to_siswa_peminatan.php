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
        Schema::table('siswas', function (Blueprint $table) {
            // Add foreign key constraints for pilihan_peminatan columns
            $table->foreign('pilihan_peminatan_1')
                ->references('id')
                ->on('peminatans')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('pilihan_peminatan_2')
                ->references('id')
                ->on('peminatans')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('pilihan_peminatan_3')
                ->references('id')
                ->on('peminatans')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            // Drop foreign keys
            $table->dropForeign(['pilihan_peminatan_1']);
            $table->dropForeign(['pilihan_peminatan_2']);
            $table->dropForeign(['pilihan_peminatan_3']);
        });
    }
};
