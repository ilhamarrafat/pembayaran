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
        Schema::create('bayar', function (Blueprint $table) {
            $table->id('Id_bayar'); // Id_pembayaran sebagai primary key
            $table->string('Nominal', 20);
            $table->enum('Metode', ['online', 'offline']);
            $table->text('Deskripsi')->nullable();
            $table->dateTime('Waktu');
            $table->boolean('Status');
            $table->string('no_transaksi', 50);
            $table->timestamps(); // Menambahkan created_at dan updated_at

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bayars');
    }
};
