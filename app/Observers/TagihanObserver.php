<?php

namespace App\Observers;

use App\Models\Tagihan;
use App\Models\Bayar;

class TagihanObserver
{
    /**
     * Handle the Tagihan "created" event.
     */
    public function created(Tagihan $tagihan): void
    {
        // Buat data pembayaran baru
        $bayar = Bayar::create([
            'nominal_bayar' => $tagihan->nominal_bayar,
            'Id_santri' => $tagihan->Id_santri,
        ]);

        // Isi id_bayar di tabel tagihan
        $tagihan->Id_bayar = $bayar->Id_bayar;
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
