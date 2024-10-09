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
            $table->unsignedBigInteger('id_transaksi')->nullable(); // Menambahkan kolom id_transaksi
        });
    }

    public function down()
    {
        Schema::table('tagihan', function (Blueprint $table) {
            $table->dropColumn('id_transaksi'); // Menghapus kolom saat rollback
        });
    }
};
