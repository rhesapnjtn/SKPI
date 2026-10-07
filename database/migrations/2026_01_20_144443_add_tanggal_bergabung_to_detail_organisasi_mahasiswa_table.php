<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('detail_organisasi_mahasiswa', function (Blueprint $table) {
        $table->date('tanggal_bergabung')->nullable()->after('status_keanggotaan');
    });
}

public function down()
{
    Schema::table('detail_organisasi_mahasiswa', function (Blueprint $table) {
        $table->dropColumn('tanggal_bergabung');
    });
}

};
