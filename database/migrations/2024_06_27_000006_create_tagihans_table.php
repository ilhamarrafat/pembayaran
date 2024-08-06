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
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id('Id_tagihan'); // Id_tagihan sebagai primary key
            $table->dateTime('Waktu_tagihan');
            $table->string('Nominal', 20);
            $table->unsignedBigInteger('Id_bayar');
            $table->timestamps(); // Menambahkan created_at dan updated_at
            // Foreign keys
           $table->foreign('Id_bayar')->references('Id_bayar')->on('bayar')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
