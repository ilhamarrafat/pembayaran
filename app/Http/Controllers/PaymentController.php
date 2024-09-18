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
        $pagination = 5;
        $articles   = tagihan::orderBy('created_at', 'desc')->paginate($pagination);

        $santri = Santri::all();
        $bayar = transaksi::all();
        $tagihan = Tagihan::all();

        return view('pembayaran.index', compact('tagihan', 'santri', 'bayar'))
            ->with('i', ($request->input('page', 1) - 1) * $pagination);
    }
    public function create()
    {
        $tagihan = tagihan::all()->map(function ($tagihan) {
            $tagihan->waktu_tagihan = new \Carbon\Carbon($tagihan->waktu_tagihan);
            return $tagihan;
        });
        $kelas = kelas::all();
        $tingkat = tingkat::all();
        return view('pembayaran.create', compact('kelas', 'tingkat', 'tagihan'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        // Validasi input
        // Validate the request
        $request->validate([
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'id_tingkat' => 'required|exists:tingkat,id_tingkat',
            'nama_tagihan' => 'required|string|max:255',
            'nominal_tagihan' => 'required|string',
            'waktu_tagihan' => 'required|date',
        ]);
        // Menghapus format rupiah dan hanya mengambil angka
        $nominal_tagihan = preg_replace('/[^\d]/', '', $request->nominal_tagihan);

        // Membuat tagihan baru
        $tagihan = new Tagihan();
        $tagihan->id_kelas = $request->id_kelas;
        $tagihan->id_tingkat = $request->id_tingkat;
        $tagihan->nama_tagihan = $request->nama_tagihan;
        $tagihan->nominal_tagihan = $nominal_tagihan; // Simpan sebagai angka
        $tagihan->waktu_tagihan = $request->waktu_tagihan;
        $tagihan->save();

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
    function export_excel()
    {
        return Excel::download(new ExportData, "DataTagihanSantri.xlsx");
    }
}
