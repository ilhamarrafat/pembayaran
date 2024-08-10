<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\tagihan;
use App\Models\User;
use illuminate\Support\Facades\File;

class superadminController extends Controller
{
    public function ajuan()
    {
        return view('superadmin.ajuan');
    }

    public function santri()
    {
        return view('superadmin.csantri');
    }

    public function index(Request $request)
    {
        $pagination = 5;
        $santris   = Santri::orderBy('created_at', 'desc')->paginate($pagination);
        // $santris = Santri::all();
        $i = ($santris->currentPage() - 1) * $pagination;
        return view('superadmin.data', compact('santris', 'i'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::all();
        $tagihan = Tagihan::all();
        return view('superadmin.csantri', compact('user', 'tagihan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id',
            'Id_tagihan',
            'foto' => 'required|file|mimes:jpg,png,pdf|max:2048',
            'nama',
            'Jenis_kelamin',
            'Tmp_lhr',
            'Tgl_lhr',
            'alamat',
            'Thn_masuk',
            'Thn_keluar',
            'kelas',
            'tingkat'
        ]);
        // dd($request->all());
        $tingkat = new Santri;
        $tingkat->tingkat = $request->tingkat;
        $foto = $request->file('foto');
        $foto_ekstensi = $foto->extension();
        $nama_foto = date('YmdHis') . "." . $foto_ekstensi;
        $foto->move(public_path('foto'), $nama_foto);
        // Menyimpan file di storage/app/public/images
        // $path = $request->foto->storeAs('public/images', $nama_foto);

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
            'kelas' => $request->input('kelas'),
            'tingkat' => $request->input('tingkat')
        ]);
        // dd($request->except('_token'));
        Santri::create($data);
        return redirect('dashboard/superadmin/data')->with('success', 'Santri berhasil ditambahkan.');
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
            'kelas' => 'required',
            'tingkat' => 'required',
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
            'kelas' => $request->input('kelas'),
            'tingkat' => $request->input('tingkat')
        ]);
        $santri = Santri::findOrFail($Id_santri);
        $user = User::all();
        $tagihan = Tagihan::all();
        // $santri = Santri::find($Id_santri);
        $santri->update($data);

        // $santri->update($request->except(['_token', '_method']));

        return redirect()->route('data', compact('santri', 'user', 'tagihan'))
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
