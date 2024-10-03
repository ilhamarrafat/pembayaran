<?php

namespace App\Http\Controllers;

use App\Models\Bayar;
use App\Models\Kelas;
use App\Models\Santri;
use App\Models\Tagihan;
use App\Models\Tingkat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class santriController extends Controller
{
    public function index(Request $request)
    {
        $santri = Santri::all();
        $jumlahUser = $santri->count();
        return view('santri.dashboard', compact('santri', 'jumlahUser'));
    }
    public function create()
    {
        $user = Auth::user();
        $santri = Santri::where('user_id', $user->id)->firstOrFail();
        $kelas = Kelas::all();
        $tingkat = Tingkat::all();
        return view('santri.profile', compact('user', 'santri', 'kelas', 'tingkat'));
    }

    public function store(Request $request)
    {
        // Validasi input, gunakan old() untuk menjaga inputan tetap ada jika ada error
        $validatedData = $request->validate([
            'foto' => 'required|file|mimes:jpg,png,pdf|max:2048',
            'nama' => 'required|string|max:255',
            'Jenis_kelamin' => 'required',
            'Tmp_lhr' => 'required|string|max:255',
            'Tgl_lhr' => 'required|date',
            'alamat' => 'required|string|max:255',
            'Thn_masuk' => 'required|date',
            'id_kelas' => 'required',
            'id_tingkat' => 'required'
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();

        // Cari data santri berdasarkan user yang login
        $santri = Santri::where('user_id', $user->id)->firstOrFail();

        // Handle file upload
        $foto = $request->file('foto');
        $foto_ekstensi = $foto->extension();
        $nama_foto = date('YmdHis') . "." . $foto_ekstensi;
        $foto->move(public_path('foto'), $nama_foto);

        // Data yang akan disimpan
        $data = [
            'user_id' => $user->id,
            'foto' => $nama_foto,
            'nama' => $request->input('nama'),
            'Jenis_kelamin' => $request->input('Jenis_kelamin'),
            'Tmp_lhr' => $request->input('Tmp_lhr'),
            'Tgl_lhr' => $request->input('Tgl_lhr'),
            'alamat' => $request->input('alamat'),
            'Thn_masuk' => $request->input('Thn_masuk'),
            'id_kelas' => $request->input('id_kelas'),
            'id_tingkat' => $request->input('id_tingkat')
        ];

        // Simpan data santri
        Santri::create($data);

        return redirect('/santri/profile')->with('success', 'Santri berhasil ditambahkan.');
    }

    public function show()
    {
        $santri = Santri::where('user_id', Auth::id())->first();
        return view('santri.profile', compact('santri'));
    }

    public function edit()
    {
        $user = Auth::user();
        $santri = Santri::where('user_id', $user->id)->firstOrFail();
        return view('santri.edit', compact('santri'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'foto' => 'file|mimes:jpg,png,pdf|max:2048',
            'nama' => 'required|string|max:255',
            'Jenis_kelamin' => 'required',
            'Tmp_lhr' => 'required|string|max:255',
            'Tgl_lhr' => 'required|date',
            'alamat' => 'required|string|max:255',
            'Thn_masuk' => 'required|date',
            'id_kelas' => 'required',
            'id_tingkat' => 'required'
        ]);

        $santri = Santri::findOrFail($id);

        if ($santri->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak berhak mengedit data ini.');
        }

        // Update data santri
        $santri->nama = $request->nama;
        $santri->Tmp_lhr = $request->Tmp_lhr;
        $santri->alamat = $request->alamat;
        $santri->Thn_masuk = $request->Thn_masuk;
        $santri->id_kelas = $request->id_kelas;
        $santri->id_tingkat = $request->id_tingkat;

        // Cek dan simpan foto jika ada
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('santri_fotos', 'public');
            $santri->foto = $path;
        }

        $santri->save();

        // Update nama user
        $user = User::findOrFail($santri->user_id);
        $user->name = $request->nama;
        $user->save();

        return redirect()->route('profile.santri')->with('success', 'Data santri berhasil diperbarui.');
    }
}
