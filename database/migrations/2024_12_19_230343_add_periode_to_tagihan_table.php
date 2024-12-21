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
        Schema::table('tagihan', function (Blueprint $table) {
            $table->string('periode_tagihan', 10)->nullable()->after('waktu_tagihan');
        });
    }

    public function down()
    {
        Schema::table('tagihan', function (Blueprint $table) {
            $table->dropColumn('periode_tagihan');
        });
    }
};
