<?php

namespace App\Http\Controllers;

use App\Exports\ExportDataTagihan;
use App\Exports\ExportDataTransaksi;
use App\Models\kelas;
use App\Models\tingkat;
use App\Models\transaksi;
use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\tagihan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
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
        $tagihans = $queryTagihan->paginate(100);
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

        $transaksis = $queryTransaksi->paginate(100);


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
        // Validasi data input
        $request->validate([
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'id_tingkat' => 'required|exists:tingkat,id_tingkat',
            'nama_tagihan' => 'required|string|max:255',
            'nominal_tagihan' => 'required|string',
            'waktu_tagihan' => 'required|date',
            'periode_tagihan' => 'required|in:satu_periode,per_periode', // Validasi radio button
        ]);

        // Mendapatkan data santri berdasarkan kelas dan tingkat
        $santris = Santri::where('id_kelas', $request->id_kelas)
            ->where('id_tingkat', $request->id_tingkat)
            ->where('status', 'aktif')
            ->get();

        if ($santris->isEmpty()) {
            return redirect()->back()->withErrors(['error' => 'Tidak ada santri ditemukan untuk kelas dan tingkat ini.']);
        }
        foreach ($santris as $santri) {

            $nominal_tagihan = preg_replace('/[^\d]/', '', $request->nominal_tagihan);
            // Jika tagihan hanya satu periode
            if ($request->periode_tagihan === 'satu_periode') {
                $tagihan = new Tagihan();
                $tagihan->Id_santri = $santri->Id_santri;
                $tagihan->id_kelas = $request->id_kelas;
                $tagihan->id_tingkat = $request->id_tingkat;
                $tagihan->nama_tagihan = $request->nama_tagihan;
                $tagihan->nominal_tagihan = $nominal_tagihan;
                $tagihan->waktu_tagihan = $request->waktu_tagihan;
                $tagihan->periode_tagihan = $request->periode_tagihan;

                if ($tagihan->save()) {
                    Log::info('Tagihan satu periode berhasil disimpan', ['tagihan' => $tagihan]);
                } else {
                    Log::error(
                        'Gagal menyimpan tagihan satu periode',
                        ['data' => $tagihan]
                    );
                }
            }
            // Jika tagihan per bulan selama setahun
            else if ($request->periode_tagihan === 'per_periode') {
                $waktu_tagihan = $request->waktu_tagihan;  // Waktu mulai tagihan
                for ($i = 0; $i < 12; $i++) {
                    // Hitung setiap bulan
                    $bulan = date('Y-m-d', strtotime("+$i month", strtotime($waktu_tagihan)));
                    $tagihan = new Tagihan();
                    $tagihan->Id_santri = $santri->Id_santri;
                    $tagihan->id_kelas = $request->id_kelas;
                    $tagihan->id_tingkat = $request->id_tingkat;
                    $tagihan->nama_tagihan = $request->nama_tagihan;
                    $tagihan->nominal_tagihan = $nominal_tagihan;
                    $tagihan->waktu_tagihan = $bulan;
                    $tagihan->periode_tagihan = $request->periode_tagihan;
                    $tagihan->save();
                }
            }
        }

        // dd($request->all());

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
        return Excel::download(new ExportDataTransaksi, 'DataTransaksiSantri.xlsx');
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
    public function export_tagihan_santri()
    {
        return Excel::download(new ExportDataTagihan, 'DataTagihanSantri.xlsx');
    }
    public function bayarPdf($id)
    {
        // Ambil data transaksi dan relasi tagihan
        $transaksi = Transaksi::with('tagihan')->findOrFail($id);

        // Siapkan data untuk view PDF
        $data = [
            'transaksi' => $transaksi,
            'santri' => $transaksi->santri, // relasi ke model Santri
            'tagihan' => $transaksi->tagihan,
        ];

        // Render HTML dari view untuk PDF
        $html = view('pembayaran.cetak', $data)->render();

        // Setel opsi dompdf
        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true); // Aktifkan remote resource

        // Inisialisasi dompdf dengan opsi
        $dompdf = new \Dompdf\Dompdf($options);

        // Load HTML ke dalam dompdf dan generate PDF
        $dompdf->loadHtml($html);

        // (Optional) Set ukuran kertas dan orientasi
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF
        $dompdf->render();

        // Output file PDF ke browser untuk diunduh
        return $dompdf->stream('tagihan_' . $transaksi->id_transaksi . '.pdf', ['Attachment' => true]); // 'Attachment' => true untuk download
    }
}
