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
        Schema::table('poin_mahasiswas', function (Blueprint $table) {
            // Ubah kolom 'poin' menjadi integer dengan default 0
            $table->integer('poin')->default(0)->change();
        });

        // Update semua record lama yang NULL jadi 0
        DB::table('poin_mahasiswas')->whereNull('poin')->update(['poin' => 0]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('poin_mahasiswas', function (Blueprint $table) {
            // Kembalikan kolom 'poin' tanpa default
            $table->integer('poin')->nullable()->change();
        });
    }
};
