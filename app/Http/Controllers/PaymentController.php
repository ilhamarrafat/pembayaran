<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\tagihan;
use App\Models\User;
use App\Models\Bayar;
use illuminate\Support\Facades\File;

class PaymentController extends Controller
{
    public function index(Request $request)
    {

        $santri = Santri::all();
        $bayar = Bayar::all();
        $tagihan = Tagihan::all();

        return view('pembayaran.index', compact('tagihan', 'santri', 'bayar'));
    }
    public function create()
    {
        $santri = Santri::all();
        $bayar = Bayar::all();
        $tagihan = Tagihan::all();
        return view('pembayaran.create');
    }
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_tagihan' => 'required|string|max:255',
            'nominal_tagihan' => 'required|numeric',
            'kelas' => 'required|integer|min:1|max:6',
            'tingkat' => 'required|string|in:MTs,MA,Salaf',
            'waktu_tagihan' => 'required|date',
        ]);
        // Simpan data tagihan
        $tagihan = Tagihan::create([
            'nama_tagihan' => $validated['nama_tagihan'],
            'nominal_tagihan' => $validated['nominal_tagihan'],
            'kelas' => $validated['kelas'],
            'tingkat' => $validated['tingkat'],
            'waktu_tagihan' => $validated['waktu_tagihan'],
        ]);
        // Ambil semua santri yang sesuai dengan tingkat dan kelas yang dipilih
        $santri = Santri::where('tingkat', $validated['tingkat'])
            ->where('kelas', $validated['kelas'])
            ->get();

        // Hubungkan setiap santri dengan tagihan yang baru dibuat
        foreach ($santri as $s) {
            Bayar::create([
                'Id_santri' => $s->id,
                'Id_tagihan' => $tagihan->id,
                'status' => 'belum_dibayar', // Default status
            ]);
        }
        // dd($tagihan, $santri);
        // Redirect ke view admin dengan data pembayaran
        return redirect()->route('pembayaran', compact('tagihan', 'santri'), $tagihan->id)->with('success', 'Tagihan berhasil ditambahkan.');

        // Redirect ke view santri dengan data pembayaran
        return redirect()->route('/pembayaran/santri', compact('tagihan', 'santri'), $tagihan->id)->with('success', 'Pembayaran berhasil disimpan dan ditampilkan di santri.');
    }
    public function showAdmin($Id_tagihan, $Id_santri)
    {

        $tagihan = Tagihan::find($Id_tagihan);
        $santri = Santri::find($Id_santri);
        return view('pembayaran.index', compact('tagihan', 'santri'))
            ->with('success', 'Tagihan created successfully.');
    }
    public function showSantri($Id_tagihan, $Id_santri)
    {
        // $tagihan = Tagihan::where('Id_santri', $Id_santri)->get();
        $tagihan = Tagihan::find($Id_tagihan);
        $santri = Santri::find($Id_santri);
        // dd($tagihan);
        return view('/santri/pembayaran/{id}', compact('tagihan', 'santri'))
            ->with('success', 'Tagihan created successfully.');
    }
}
