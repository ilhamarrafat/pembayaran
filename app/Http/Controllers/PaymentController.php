<?php

namespace App\Http\Controllers;

use App\Exports\ExportData;
use App\Models\kelas;
use App\Models\tingkat;
use App\Models\transaksi;
use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\tagihan;
use App\Models\User;
use illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Midtrans\Transaction;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kelas = $request->input('kelas');
        $tingkat = $request->input('tingkat');
        $query = Tagihan::query();
        // Pencarian berdasarkan nama tagihan
        if ($search) {
            $query->where('nama_tagihan', 'like', '%' . $search . '%');
        }

        // Filter berdasarkan kelas
        if ($kelas) {
            $query->where('id_kelas', $kelas);
        }

        // Filter berdasarkan tingkat
        if ($tingkat) {
            $query->where('id_tingkat', $tingkat);
        }

        // Dapatkan data tagihan dengan filter dan pagination
        $tagihan = $query->paginate(5);
        $pagination = 5;
        $tagihans   = tagihan::orderBy('created_at', 'desc')->paginate($pagination);
        $kelas = kelas::all();
        $santri = Santri::all();
        $tingkat = tingkat::all();
        $transaksis = Transaksi::with('santri')->get();
        $tagihan = Tagihan::all();

        return view('pembayaran.index', compact('transaksis', 'tagihan', 'santri',  'kelas', 'tingkat'))
            ->with('i', ($request->input('page', 1) - 1) * $pagination);
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

        // Cek jika tidak ada santri yang ditemukan
        if ($santris->isEmpty()) {
            return redirect()->back()->withErrors(['error' => 'Tidak ada santri ditemukan untuk kelas dan tingkat ini.']);
        }

        foreach ($santris as $santri) {
            // Membuat tagihan baru untuk setiap santri
            $tagihan = new Tagihan();
            $tagihan->Id_santri = $santri->id;
            $tagihan->id_kelas = $request->id_kelas;
            $tagihan->id_tingkat = $request->id_tingkat;
            $tagihan->nama_tagihan = $request->nama_tagihan;
            $tagihan->nominal_tagihan = $nominal_tagihan; // Simpan sebagai angka
            $tagihan->waktu_tagihan = $request->waktu_tagihan;
            $tagihan->save();
        }

        return redirect()->route('pembayaran')->with('success', 'Tagihan berhasil ditambahkan.');
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

    function export_excel()
    {
        return Excel::download(new ExportData, "DataTagihanSantri.xlsx");
    }
}
