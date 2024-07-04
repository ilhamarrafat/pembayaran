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
        Schema::create('Admin', function (Blueprint $table) {
            $table->id('id_admin');
            $table->string('username', 10);
            $table->string('email')->unique();
            $table->string('password', 20);
            $table->string('foto', 200);
            $table->unsignedBigInteger('Id_level');
            $table->foreign('Id_level')->references('id_level')->on('level')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};