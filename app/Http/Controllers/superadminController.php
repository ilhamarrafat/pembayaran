<?php

namespace App\Http\Controllers;

use App\Models\kelas;
use App\Models\tingkat;
use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\tagihan;
use App\Models\User;
use illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class superadminController extends Controller
{
    public function index(Request $request)
    {
        $santri = Santri::all();
        $jumlahUser = $santri->count();
        return view('superadmin.dashboard', compact('santri', 'jumlahUser'));
    }
    public function ajuan()
    {
        return view('superadmin.ajuan');
    }

    public function santri()
    {
        return view('superadmin.csantri');
    }

    public function data(Request $request)
    {
        $pagination = 5;
        $santri  = Santri::orderBy('created_at', 'desc')->paginate($pagination);
        // $santris = Santri::all();
        $kelas = Kelas::all();
        $tingkat = tingkat::all();
        $i = ($santri->currentPage() - 1) * $pagination;
        return view('superadmin.data', compact('santri', 'i', 'kelas', 'tingkat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::all();
        $tagihan = Tagihan::all();
        $santri = Santri::all();
        $kelas = Kelas::all();
        $tingkat = tingkat::all();
        return view('superadmin.csantri', compact('user', 'tagihan', 'santri', 'kelas', 'tingkat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'foto' => 'required|file|mimes:jpg,png,pdf|max:2048',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'telepon' => 'required',
            'Jenis_kelamin' => 'required',
            'Tmp_lhr' => 'required|string|max:255',
            'Tgl_lhr' => 'required|date',
            'alamat' => 'required|string',
            'Thn_masuk' => 'required|date',
            'Thn_keluar' => 'nullable|date',
            'id_kelas' => 'required|integer',
            'id_tingkat' => 'required|integer'
        ]);

        // Upload foto
        $foto = $request->file('foto');
        $foto_ekstensi = $foto->extension();
        $nama_foto = date('YmdHis') . "." . $foto_ekstensi;

        // Simpan foto ke dalam folder 'storage/app/public/foto'
        $foto->storeAs('public/foto', $nama_foto);

        // Buat user baru
        $user = User::create([
            'name' => $request->input('nama'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role_id' => 3, // Peran santri
        ]);

        // Buat data santri baru
        Santri::create([
            'user_id' => $user->id,
            'foto' => 'foto/' . $nama_foto, // Simpan path foto ke database
            'nama' => $request->input('nama'),
            'Jenis_kelamin' => $request->input('Jenis_kelamin'),
            'Tmp_lhr' => $request->input('Tmp_lhr'),
            'Tgl_lhr' => $request->input('Tgl_lhr'),
            'alamat' => $request->input('alamat'),
            'Thn_masuk' => $request->input('Thn_masuk'),
            'Thn_keluar' => $request->input('Thn_keluar'),
            'id_kelas' => $request->input('id_kelas'),
            'id_tingkat' => $request->input('id_tingkat'),
            'telepon' => $request->input('telepon')
        ]);

        // Redirect ke halaman data dengan pesan sukses
        return redirect()->route('data')
            ->with('success', 'Santri berhasil ditambahkan.');
    }



    /**
     * Display the specified resource.
     */
    public function show($Id_santri)
    {

        $santris = Santri::find($Id_santri);
        return redirect()->route('data', compact('santri'))
            ->with('success', 'Santri created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($Id_santri)
    {
        $santris = Santri::findOrFail($Id_santri);
        $user = User::all();
        $tagihan = Tagihan::all();
        return view('superadmin.edits', compact('santris', 'user', 'tagihan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $Id_santri)
    {

        $validatedData = $request->validate([
            'foto',
            'nama' => 'required',
            'Jenis_kelamin' => 'required',
            'Tmp_lhr' => 'required',
            'Tgl_lhr' => 'required',
            'alamat' => 'required',
            'Thn_masuk' => 'required',
            'Thn_keluar',
            'id_kelas',
            'id_tingkat'
        ]);
        $foto = $request->file('foto');
        $foto_ekstensi = $foto->extension();
        $nama_foto = date('YmdHis') . "." . $foto_ekstensi;
        $foto->move(public_path('foto'), $nama_foto);
        $data = ([
            'user_id' => $request->input('user_id'),
            'Id_tagihan' => $request->input('Id_tagihan'),
            'foto' => $nama_foto,
            'nama' => $request->input('nama'),
            'Jenis_kelamin' => $request->input('Jenis_kelamin'),
            'Tmp_lhr' => $request->input('Tmp_lhr'),
            'Tgl_lhr' => $request->input('Tgl_lhr'),
            'alamat' => $request->input('alamat'),
            'Thn_masuk' => $request->input('Thn_masuk'),
            'Thn_keluar' => $request->input('Thn_keluar'),
            'id_kelas' => $request->input('id_kelas'),
            'id_tingkat' => $request->input('id_tingkat')
        ]);
        $santri = Santri::findOrFail($Id_santri);
        $user = User::all();
        $tagihan = Tagihan::all();
        $kelas = kelas::all();
        // $santri = Santri::find($Id_santri);
        $santri->update($data);

        // $santri->update($request->except(['_token', '_method']));

        return redirect()->route('/dashboard/superadmin/data', compact('santri', 'user', 'tagihan', 'kelas', 'tingkat'))
            ->with('success', 'Santri updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($Id_santri)
    {
        $santris = Santri::findOrFail($Id_santri);
        $santris->delete();
        return redirect()->route('data')
            ->with('success', 'Santri deleted successfully.');
    }
}
