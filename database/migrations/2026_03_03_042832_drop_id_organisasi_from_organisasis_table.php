<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organisasis', function (Blueprint $table) {
            $table->dropColumn('id_organisasi'); // hapus kolom
        });
    }

    public function down(): void
    {
        Schema::table('organisasis', function (Blueprint $table) {
            $table->string('id_organisasi')->unique(); // rollback
        });
    }
};