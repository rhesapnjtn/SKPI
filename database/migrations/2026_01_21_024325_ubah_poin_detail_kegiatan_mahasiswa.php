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
        Schema::table('detail_kegiatan_mahasiswa', function (Blueprint $table) {
            // Ubah kolom poin jadi INT dan default 0
            $table->integer('poin')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_kegiatan_mahasiswa', function (Blueprint $table) {
            // Rollback ke tipe sebelumnya, misal tinyInteger
            $table->tinyInteger('poin')->default(0)->change();
        });
    }
};
