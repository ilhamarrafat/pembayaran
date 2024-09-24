<?php

namespace App\Observers;

use App\Models\Tagihan;
use App\Models\transaksi;
use Illuminate\Support\Facades\Log;

class TagihanObserver
{
    /**
     * Handle the Tagihan "created" event.
     */
    public function created(Tagihan $tagihan): void
    {
        // Pastikan Id_santri tidak null
        if (is_null($tagihan->Id_santri)) {
            Log::error('Id_santri is null when creating transaction');
            return; // Mungkin Anda ingin melempar exception di sini
        }

        // Buat data transaksi baru menggunakan model Transaksi
        $transaksi = transaksi::create([
            'nominal_bayar' => $tagihan->nominal_tagihan,
            'Id_santri' => $tagihan->Id_santri,
            'waktu_transaksi' => now(),
            'status_transaksi' => 'unpaid',
            'deskripsi' => $tagihan->nama_tagihan,
        ]);

        // Update tagihan dengan id_transaksi yang baru dibuat (jika diperlukan)
        $tagihan->id_transaksi = $transaksi->id_transaksi;
        $tagihan->save(); // Simpan perubahan
    }


    /**
     * Handle the Tagihan "updated" event.
     */
    public function updated(Tagihan $tagihan): void
    {
        //
    }

    /**
     * Handle the Tagihan "deleted" event.
     */
    public function deleted(Tagihan $tagihan): void
    {
        //
    }

    /**
     * Handle the Tagihan "restored" event.
     */
    public function restored(Tagihan $tagihan): void
    {
        //
    }

    /**
     * Handle the Tagihan "force deleted" event.
     */
    public function forceDeleted(Tagihan $tagihan): void
    {
        //
    }
}
