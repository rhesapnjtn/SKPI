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
    Schema::table('poin_mahasiswas', function (Blueprint $table) {
        $table->integer('poin_tambahan')->default(0)->after('poin');
    });
}

public function down()
{
    Schema::table('poin_mahasiswas', function (Blueprint $table) {
        $table->dropColumn('poin_tambahan');
    });
}

};
