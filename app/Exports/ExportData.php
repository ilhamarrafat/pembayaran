<?php

namespace App\Exports;

use App\Models\Tagihan;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ExportData implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $tagihan = Tagihan::orderBy('nama_tagihan', 'asc')->get(); // Mengambil semua data
        return view('pembayaran.tagihan', ['tagihan' => $tagihan]);
    }
}
