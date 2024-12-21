<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use illuminate\Support\Facades\File;
use Symfony\Contracts\Service\Attribute\Required;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pagination = 5;
        $beritas = Berita::orderBy('created_at', 'desc')->paginate($pagination);
        if ($beritas->isEmpty()) {
            return view('berita.index', ['beritas' => [], 'i' => 0]);
        }

        $i = ($beritas->currentPage() - 1) * $pagination;
        return view('berita.index', compact('beritas', 'i'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $berita = Berita::all();
        return view('berita.create', compact('berita'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validasi = $request->validate([
            'gambar' => 'required|file|mimes:jpg,png,pdf',
            'judul' => 'required',
            'isi' => 'required'
        ]);
        $gambar = $request->file('gambar');
        $gambar_ekstensi = $gambar->extension();
        $nama_gambar = date('YmdHis') . "." . $gambar_ekstensi;
        $gambar->move(public_path('gambar'), $nama_gambar);


        $Data = ([
            'gambar' => $nama_gambar,
            'judul' => $request->input('judul'),
            'isi' => $request->input('isi')
        ]);
        Berita::create($Data);
        return redirect('/berita')->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $beritas = Berita::find($id);
        return redirect()->route('berita', compact('beritas'))
            ->with('Berita, Berhasil ditambahkan!!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $beritas = Berita::findOrFail($id);
        return redirect('berita.edit')->with('success', 'Berita berhasil diedit.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validasi = $request->validate([
            'gambar' => 'required|file|mimes:jpg,png,pdf|max:2048',
            'judul' => 'required',
            'isi' => 'required|file|mimes:jpg,png,pdf|max:2048'
        ]);
        $gambar = $request->file('gambar');
        $gambar_ekstensi = $gambar->extension();
        $nama_gambar = date('YmdHis') . "." . $gambar_ekstensi;
        $gambar->move(public_path('gambar'), $nama_gambar);


        $Data = ([
            'gambar' => $nama_gambar,
            'judul' => $request->input('judul'),
            'isi' => $request->input('isi')
        ]);
        $beritas = Berita::findOrFail($id);
        $beritas->update();
        // Berita::update($Data);
        return redirect('/berita')->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $beritas = Berita::findOrFail($id);
        $beritas->delete();
        return redirect()->route('berita')
            ->with('success', 'Santri deleted successfully.');
    }
    public function tampil($slug)
    {
        $berita = Berita::where('slug', $slug)->first();

        if (!$berita) {
            abort(404); // Jika berita tidak ditemukan
        }

        return view('berita.tampil', compact('berita'));
    }
}
