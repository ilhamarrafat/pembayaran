<?php

namespace App\Exports;

use App\Models\Santri;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportDataSantri implements FromCollection, WithHeadings
{
    /**
     * Mengambil data santri untuk diekspor.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Menggunakan eager loading untuk mengoptimalkan query
        return Santri::with(['kelas', 'tingkat'])
            ->orderBy('nama', 'asc')
            ->get(['Id_santri', 'nama', 'Jenis_kelamin', 'alamat', 'Tmp_lhr', 'Tgl_lhr', 'Thn_masuk', 'Thn_keluar', 'id_kelas', 'id_tingkat', 'telepon']);
    }

    /**
     * Menentukan header kolom untuk file Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Id_santri',
            'Nama',
            'Jenis Kelamin',
            'Alamat',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Tahun Masuk',
            'Tahun Keluar',
            'Kelas',
            'TingKat',
            'Telepon'
        ];
    }
}
