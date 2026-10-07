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
            $table->integer('poin')->change(); // ubah tipe jadi INT
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_kegiatan_mahasiswa', function (Blueprint $table) {
            $table->tinyInteger('poin')->change(); // rollback ke tipe sebelumnya (jika perlu)
        });
    }
};
