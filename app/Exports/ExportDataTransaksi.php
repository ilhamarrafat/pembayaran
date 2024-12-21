<?php

namespace App\Exports;

use App\Models\Tagihan;
use App\Models\transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportDataTransaksi implements FromCollection, WithHeadings
{
    /**
     * Mengambil data transaksi untuk diekspor.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Menggunakan eager loading untuk mengoptimalkan query
        return transaksi::with(['santri'])
            ->orderBy('id_transaksi', 'asc')
            ->get(['id_transaksi', 'Id_santri', 'total_bayar', 'jenis_pembayaran', 'waktu_transaksi', 'status_transaksi', 'deskripsi']);
    }

    /**
     * Menentukan header kolom untuk file Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nomor Transaksi',
            'Nama Santri',
            'Jumlah Pembayaran',
            'Metode Pembayaran',
            'Tanggal Pembayaran',
            'Status Transaksi',
            'Deskripsi Transaksi',
        ];
    }
}
