<?php

namespace App\Exports;

use App\Models\Tagihan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportDataTagihan implements FromCollection, WithHeadings
{
    /**
     * Mengambil data transaksi untuk diekspor.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Menggunakan eager loading untuk mengoptimalkan query
        return Tagihan::with(['santri'])
            ->orderBy('id_transaksi', 'asc')
            ->get(['Id_tagihan', 'nama_tagihan', 'id_tingkat', 'id_kelas', 'nominal_tagihan',  'waktu_tagihan', 'id_transaksi']);
    }

    /**
     * Menentukan header kolom untuk file Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Id',
            'Nama Tagihan',
            'Tingkat',
            'Kelas',
            'Nominal',
            'Waktu',
            'Id Transaksi',
        ];
    }
}
