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
                $table->enum('Jenis_kelamin', ['laki-laki', 'perempuan']);
                $table->text('Tmp_lhr');
                $table->date('Tgl_lhr');
                $table->text('alamat');
                $table->date('Thn_masuk');
                $table->enum('kelas', ['Mts', 'MA', 'Salaf']);
                $table->string('username', 10);
                $table->string('password', 50);
                $table->unsignedBigInteger('Id_level');
                $table->unsignedBigInteger('Id_tagihan');
                $table->timestamps(); // Menambahkan created_at dan updated_at

                // Foreign keys
                $table->foreign('Id_level')->references('id_level')->on('level')->onDelete('cascade');
                $table->foreign('Id_tagihan')->references('Id_tagihan')->on('tagihan')->onDelete('cascade');
            });
        Schema::table('Santri', function (Blueprint $table) {
            $table->string('role')->default('user'); // Menambahkan kolom role dengan nilai default 'user'
        });   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('santri', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
