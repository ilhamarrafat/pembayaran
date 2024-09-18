<?php

namespace App\Http\Controllers;

use App\Models\Bayar;
use App\Models\kelas;
use App\Models\Santri;
use App\Models\tagihan;
use App\Models\tingkat;
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
        $kelas = kelas::all();
        $tingkat = Tingkat::all();
        return view('santri.profile', compact('user', 'santri', 'kelas', 'tingkat'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id',
            'foto' => 'required|file|mimes:jpg,png,pdf|max:2048',
            'nama',
            'Jenis_kelamin',
            'Tmp_lhr',
            'Tgl_lhr',
            'alamat',
            'Thn_masuk',
            'id_kelas',
            'id_tingkat'
        ]);
        // Ambil user yang sedang login
        $user = Auth::user();
        // Cari data santri berdasarkan id_user dari user yang login
        $santri = Santri::where('user_id', $user->id)->firstOrFail();
        // dd($request->all());
        $foto = $request->file('foto');
        $foto_ekstensi = $foto->extension();
        $nama_foto = date('YmdHis') . "." . $foto_ekstensi;
        $foto->move(public_path('foto'), $nama_foto);

        $data = (
            [
                'user_id' => Auth::id(),
                'foto' => $nama_foto,
                'nama' => $request->input('nama', 'name'),
                'Jenis_kelamin' => $request->input('Jenis_kelamin'),
                'Tmp_lhr' => $request->input('Tmp_lhr'),
                'Tgl_lhr' => $request->input('Tgl_lhr'),
                'alamat' => $request->input('alamat'),
                'Thn_masuk' => $request->input('Thn_masuk'),
                'id_kelas' => $request->input('id_kelas'),
                'id_tingkat' => $request->input('id_tingkat')
            ]);
        // dd($data, $user);
        Santri::create($data);
        return redirect('/santri/profile/')->with('success', 'Santri berhasil ditambahkan.');
    }
    public function show()
    {
        // Ambil data santri berdasarkan user yang sedang login
        $santri = Santri::where('user_id', Auth::id())->first();

        return view('santri.profile', compact('santri'));
    }
    // Method untuk menampilkan form edit
    public function edit()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Cari data santri berdasarkan id_user dari user yang login
        $santri = Santri::where('user_id', $user->id)->firstOrFail();

        // Tampilkan view dengan data santri
        return view('santri.edit', compact('santri'));
    }

    // Method untuk memperbarui data santri
    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'foto' => 'required|file|mimes:jpg,png,pdf|max:2048',
            'nama',
            'Jenis_kelamin',
            'Tmp_lhr',
            'Tgl_lhr',
            'alamat',
            'Thn_masuk',
            'id_kelas',
            'id_tingkat'
        ]);

        // Ambil data santri yang akan diupdate
        $santri = Santri::findOrFail($id);

        // Cek apakah santri yang diedit adalah milik user yang sedang login
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

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('santri_fotos', 'public');
            $santri->foto = $path;
        }

        $santri->save();

        // Update nama user yang terkait dengan santri ini
        $user = User::findOrFail($santri->user_id);
        $user->name = $request->nama;
        $user->save();

        // Redirect atau kembalikan response sesuai kebutuhan
        return redirect()->route('profile.santri')->with('success', 'Data santri berhasil diperbarui.');
    }
}
