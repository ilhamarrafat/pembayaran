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
            Schema::create('Santri', function (Blueprint $table) {
                $table->id('Id_santri'); // Id_santri sebagai primary key
                $table->string('foto', 200);
                $table->string('nama', 50);
                $table->string('kelas', 2);
                $table->enum('Jenis_kelamin', ['laki-laki', 'perempuan']);
                $table->text('Tmp_lhr');
                $table->date('Tgl_lhr');
                $table->text('alamat');
                $table->date('Thn_masuk');
                $table->date('Thn_keluar');
                $table->enum('tingkat', ['Mts', 'MA', 'Salaf']);
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('Id_tagihan');
                $table->timestamps();

                // Foreign keys
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('Id_tagihan')->references('Id_tagihan')->on('tagihan')->onDelete('cascade');
            }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('santris');
    }
};
