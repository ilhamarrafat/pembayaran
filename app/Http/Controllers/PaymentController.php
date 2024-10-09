<?php

namespace App\Http\Controllers;

use App\Exports\ExportData;
use App\Exports\ExportDataTagihan;
use App\Models\kelas;
use App\Models\tingkat;
use App\Models\transaksi;
use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\tagihan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Midtrans\Transaction;
use Mpdf\Mpdf;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        // Input dari request untuk pencarian tagihan
        $searchTagihan = $request->input('search_tagihan');
        $kelasTagihan = $request->input('kelas_tagihan');
        $tingkatTagihan = $request->input('tingkat_tagihan');
        // Input dari request untuk pencarian transaksi
        $searchTransaksi = $request->input('search_transaksi');
        $statusTransaksi = $request->input('status_transaksi');

        $queryTagihan = Tagihan::query();

        if ($searchTagihan) {
            $queryTagihan->where('nama_tagihan', 'like', '%' . $searchTagihan . '%');
        }

        // Filter berdasarkan kelas
        if ($kelasTagihan) {
            $queryTagihan->where('id_kelas', $kelasTagihan);
        }

        // Filter berdasarkan tingkat
        if ($tingkatTagihan) {
            $queryTagihan->where('id_tingkat', $tingkatTagihan);
        }
        $tagihans = $queryTagihan->paginate(5);
        // dd($tagihans->toArray());
        $kelas = kelas::all();
        $tingkat = tingkat::all();

        $queryTransaksi = transaksi::with('santri');

        if ($searchTransaksi) {
            $queryTransaksi->whereHas('santri', function ($q) use ($searchTransaksi) {
                $q->where('nama', 'like', '%' . $searchTransaksi . '%');
            });
        }

        if ($statusTransaksi) {
            $queryTransaksi->where('status_transaksi', $statusTransaksi);
        }

        $transaksis = $queryTransaksi->paginate(5);


        // Return ke view dengan data yang sudah difilter
        return view('pembayaran.index', compact('transaksis', 'tagihans', 'kelas', 'tingkat'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $tagihan = tagihan::all()->map(function ($tagihan) {
            $tagihan->waktu_tagihan = new \Carbon\Carbon($tagihan->waktu_tagihan);
            return $tagihan;
        });
        // Ambil semua kelas dan tingkat
        $kelas = Kelas::all();
        $tingkat = Tingkat::all();
        return view('pembayaran.create', compact('kelas', 'tingkat', 'tagihan'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'id_tingkat' => 'required|exists:tingkat,id_tingkat',
            'nama_tagihan' => 'required|string|max:255',
            'nominal_tagihan' => 'required|string',
            'waktu_tagihan' => 'required|date',
        ]);

        // Menghapus format rupiah dan hanya mengambil angka
        $nominal_tagihan = preg_replace('/[^\d]/', '', $request->nominal_tagihan);

        // Mendapatkan santri berdasarkan kelas dan tingkat
        $santris = Santri::where('id_kelas', $request->id_kelas)
            ->where('id_tingkat', $request->id_tingkat)
            ->get();
        // dd($santris);

        // Cek jika tidak ada santri yang ditemukan
        if ($santris->isEmpty()) {
            return redirect()->back()->withErrors(['error' => 'Tidak ada santri ditemukan untuk kelas dan tingkat ini.']);
        }

        foreach ($santris as $santri) {
            // Membuat tagihan baru untuk setiap santri
            $tagihan = new Tagihan();
            $tagihan->Id_santri = $santri->Id_santri;
            $tagihan->id_kelas = $request->id_kelas;
            $tagihan->id_tingkat = $request->id_tingkat;
            $tagihan->nama_tagihan = $request->nama_tagihan;
            $tagihan->nominal_tagihan = $nominal_tagihan;
            $tagihan->waktu_tagihan = $request->waktu_tagihan;
            $tagihan->save();
        }
        // dd($tagihan);
        return redirect()->route('pembayaran.index')->with('success', 'Tagihan berhasil ditambahkan.');
    }

    public function show($Id_tagihan, $Id_santri)
    {

        $tagihan = Tagihan::find($Id_tagihan);
        $santri = Santri::find($Id_santri);
        return view('pembayaran.index', compact('tagihan', 'santri', 'kelas', 'tingkat'))
            ->with('success', 'Tagihan created successfully.');
    }
    public function showSantri($Id_tagihan, $Id_santri)
    {
        $tagihan = Tagihan::where('Id_santri', $Id_santri)->get();
        $tagihan = Tagihan::find($Id_tagihan);
        $santri = Santri::find($Id_santri);
        // dd($tagihan);
        return view('/santri/pembayaran/{id}', compact('tagihan', 'santri'))
            ->with('success', 'Tagihan created successfully.');
    }

    public function edit($id_tagihan)
    {
        // Cari tagihan berdasarkan id
        $tagihan = Tagihan::find($id_tagihan);
        $kelas = Kelas::all();
        $tingkat = Tingkat::all();

        // Pastikan tagihan ditemukan, jika tidak redirect dengan pesan error
        if (!$tagihan) {
            return redirect()->route('pembayaran.index')->with('error', 'Tagihan tidak ditemukan.');
        }

        // Tampilkan form edit dengan data tagihan
        return view('pembayaran.edit', compact('tagihan', 'kelas', 'tingkat'));
    }

    public function update(Request $request, $id_tagihan)
    {
        // Validasi input
        $request->validate([
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'id_tingkat' => 'required|exists:tingkat,id_tingkat',
            'nama_tagihan' => 'required|string|max:255',
            'nominal_tagihan' => 'required|string',
            'waktu_tagihan' => 'required|date',
        ]);

        // Cari tagihan berdasarkan id
        $tagihan = tagihan::find($id_tagihan);

        if (!$tagihan) {
            return redirect()->route('pembayaran.index')->with('error', 'Tagihan tidak ditemukan.');
        }

        // Menghapus format rupiah dan hanya mengambil angka
        $nominal_tagihan = preg_replace('/[^\d]/', '', $request->nominal_tagihan);

        // Update data tagihan
        $tagihan->id_kelas = $request->id_kelas;
        $tagihan->id_tingkat = $request->id_tingkat;
        $tagihan->nama_tagihan = $request->nama_tagihan;
        $tagihan->nominal_tagihan = $nominal_tagihan; // Simpan sebagai angka
        $tagihan->waktu_tagihan = $request->waktu_tagihan;
        $tagihan->save();

        return redirect()->route('pembayaran.index')->with('success', 'Tagihan berhasil diperbarui.');
    }

    public function destroy($id_tagihan)
    {
        // Cari tagihan berdasarkan id
        $tagihan = tagihan::find($id_tagihan);

        if (!$tagihan) {
            return redirect()->route('pembayaran.index')->with('error', 'Tagihan tidak ditemukan.');
        }

        // Hapus tagihan
        $tagihan->delete();

        return redirect()->route('pembayaran.index')->with('success', 'Tagihan berhasil dihapus.');
    }

    public function export_tagihan()
    {
        return Excel::download(new ExportDataTagihan, 'DataTagihanSantri.xlsx');
    }
    public function transaksi(Request $request)
    {
        $pagination = 5;
        $santri = Santri::find(Auth::user()->santri->Id_santri);

        // Mendapatkan nilai filter dari request (pencarian dan status)
        $status = $request->input('status'); // Filter status 'paid' atau 'unpaid'
        $search = $request->input('search'); // Pencarian berdasarkan nama santri atau kolom lain

        // Query dasar untuk transaksi santri
        $query = Transaksi::with('santri')
            ->where('Id_santri', $santri->Id_santri);

        // Jika ada pencarian, tambahkan filter pencarian
        if ($search) {
            $query->whereHas('santri', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            });
        }

        // Jika ada filter status, tambahkan filter status
        if ($status) {
            $query->where('status_transaksi', $status);
        }

        // Eksekusi query dan paginasi
        $transaksis = $query->paginate($pagination);

        // Jika data tidak ditemukan, tambahkan pesan flash
        if ($transaksis->isEmpty()) {
            session()->flash('error', 'Data tidak ditemukan.');
        }

        return view('pembayaran.transaksi', compact('transaksis'))
            ->with('i', ($request->input('page', 1) - 1) * $pagination);
    }
    public function export(Request $request)
    {
        $searchTagihan = $request->input('search_tagihan');
        $kelasTagihan = $request->input('kelas_tagihan');
        $tingkatTagihan = $request->input('tingkat_tagihan');

        $queryTagihan = Tagihan::query();

        // Pencarian berdasarkan nama tagihan
        if ($searchTagihan) {
            $queryTagihan->where('nama_tagihan', 'like', '%' . $searchTagihan . '%');
        }

        // Filter berdasarkan kelas
        if ($kelasTagihan) {
            $queryTagihan->where('id_kelas', $kelasTagihan);
        }

        // Filter berdasarkan tingkat
        if ($tingkatTagihan) {
            $queryTagihan->where('id_tingkat', $tingkatTagihan);
        }

        $tagihans = $queryTagihan->get();

        // Inisialisasi mPDF
        $mpdf = new Mpdf();

        // Buat HTML untuk export
        $html = '
        <h1>Daftar Tagihan</h1>
        <table border="1" cellspacing="0" cellpadding="10">
            <thead>
                <tr>
                    <th>Nama Tagihan</th>
                    <th>Nominal Tagihan</th>
                    <th>Waktu Tagihan</th>
                    <th>Kelas</th>
                    <th>Tingkat</th>
                </tr>
            </thead>
            <tbody>
    ';

        foreach ($tagihans as $tagihan) {
            $html .= '
            <tr>
                <td>' . $tagihan->nama_tagihan . '</td>
                <td>' . number_format($tagihan->nominal_tagihan, 0, ',', '.') . '</td>
                <td>' . $tagihan->waktu_tagihan . '</td>
                <td>' . ($tagihan->kelas->nama_kelas ?? '-') . '</td>
                <td>' . ($tagihan->tingkat->nama_tingkat ?? '-') . '</td>
            </tr>
        ';
        }

        $html .= '
            </tbody>
        </table>
    ';

        // Tulis HTML ke file PDF
        $mpdf->WriteHTML($html);

        // Output ke file
        $mpdf->Output('tagihan.pdf', 'D'); // 'D' untuk download
    }
}
