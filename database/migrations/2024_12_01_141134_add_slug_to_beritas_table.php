<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            if (!Schema::hasColumn('beritas', 'slug')) {
                $table->string('slug')->nullable()->after('judul');
            }
        });

        // Tambahkan slug untuk data yang sudah ada
        $beritas = \App\Models\Berita::all();
        foreach ($beritas as $berita) {
            if (empty($berita->slug)) {
                $berita->slug = \Illuminate\Support\Str::slug($berita->judul ?? 'berita-' . $berita->id);
                $berita->save();
            }
        }
    }

    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            if (Schema::hasColumn('beritas', 'slug')) {
                $table->dropColumn('slug');
            }
        });
    }
};
