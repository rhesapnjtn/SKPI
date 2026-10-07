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
            // ubah enum tipe, tambahkan 'manual'
            $table->enum('tipe', ['kegiatan', 'organisasi', 'manual'])->default('manual')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('poin_mahasiswas', function (Blueprint $table) {
            // kembalikan seperti semula
            $table->enum('tipe', ['kegiatan', 'organisasi'])->default('kegiatan')->change();
        });
    }
};
