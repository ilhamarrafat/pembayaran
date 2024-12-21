<?php

namespace App\Http\Controllers;

use App\Exports\ExportData;
use App\Models\Admin;
use App\Models\kelas;
use App\Models\tingkat;
use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\tagihan;
use App\Models\User;
use App\Exports\ExportDataSantri;
use App\Exports\ExportDataTagihan;
use App\Models\transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;

class superadminController extends Controller
{
    public function index(Request $request)
    {
        $santri = Santri::all();
        $jumlahUser = $santri->count();
        $user = Auth::user();
        $admin = Admin::where('user_id', Auth::id())->first();
        // dd($admin);
        $totalPembayaran = Transaksi::where('status_transaksi', 'paid')->sum('total_bayar');
        $totalTagihanBelumDibayar = Transaksi::where('status_transaksi', 'unpaid')->sum('total_bayar');
        $pemasukanBulanIni = Transaksi::where('status_transaksi', 'paid')
            ->whereMonth('waktu_transaksi', Carbon::now()->month)
            ->whereYear('waktu_transaksi', Carbon::now()->year)
            ->sum('total_bayar');

        return view('superadmin.dashboard', compact('santri', 'admin', 'jumlahUser', 'pemasukanBulanIni', 'totalPembayaran', 'totalTagihanBelumDibayar'));
    }

    public function santri()
    {
        return view('superadmin.csantri');
    }

    public function data(Request $request)
    {
        $pagination = 5;
        $santris  = Santri::orderBy('created_at', 'desc')->paginate($pagination);
        // $santris = Santri::all();
        $kelas = Kelas::all();
        $tingkat = tingkat::all();
        $i = ($santris->currentPage() - 1) * $pagination;
        return view('superadmin.data', compact('santris', 'i', 'kelas', 'tingkat'));
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
            'wali_santri' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'telepon' => 'nullable|string|max:13',
            'Jenis_kelamin' => 'required',
            'Tmp_lhr' => 'required|string|max:255',
            'Tgl_lhr' => 'required|date',
            'alamat' => 'required|string',
            'Thn_masuk' => 'required|date',
            'Thn_keluar' => 'nullable|date',
            'id_kelas' => 'required|integer',
            'id_tingkat' => 'required|integer',
            'status' => 'required'
        ]);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $foto_ekstensi = $foto->extension();
            $nama_foto = date('YmdHis') . "." . $foto_ekstensi;

            // foto 'storage/app/public/foto'
            $foto->storeAs('public/foto', $nama_foto);

            // path foto ke dalam database (NO'public/')
            $validatedData['foto'] = 'foto/' . $nama_foto;
        }
        //     dd([
        //     'foto_path_in_database' => $validatedData['foto'] ?? null,
        //     'file_exists' => file_exists(storage_path('app/public/' . ($validatedData['foto'] ?? ''))),
        //     'storage_path' => storage_path('app/public/' . ($validatedData['foto'] ?? '')),
        // ]);


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
            'foto' => 'storage/foto/' . $nama_foto, // Simpan path foto ke database
            'nama' => $request->input('nama'),
            'wali_santri' => $request->input('wali_santri'),
            'Jenis_kelamin' => $request->input('Jenis_kelamin'),
            'Tmp_lhr' => $request->input('Tmp_lhr'),
            'Tgl_lhr' => $request->input('Tgl_lhr'),
            'alamat' => $request->input('alamat'),
            'Thn_masuk' => $request->input('Thn_masuk'),
            'Thn_keluar' => $request->input('Thn_keluar'),
            'id_kelas' => $request->input('id_kelas'),
            'id_tingkat' => $request->input('id_tingkat'),
            'telepon' => $request->input('telepon'),
            'status' => $request->input('status')
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
        return redirect()->route('data', compact('santris'))
            ->with('success', 'Santri created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($Id_santri)
    {

        $santris = Santri::with('user')->findOrFail($Id_santri);
        $user = User::all();
        // $tagihan = Tagihan::all();
        $kelas = Kelas::all();
        $tingkat = tingkat::all();
        return view('superadmin.edits', compact('santris', 'user', 'kelas', 'tingkat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $Id_santri)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'wali_santri' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $Id_santri . ',id', // Validasi email pada tabel `users`
            'password' => 'nullable|string|min:8|confirmed',
            'Jenis_kelamin' => 'required',
            'Tmp_lhr' => 'required|string|max:255',
            'Tgl_lhr' => 'required|date',
            'alamat' => 'required|string',
            'Thn_masuk' => 'required|date',
            'Thn_keluar' => 'nullable|date',
            'id_kelas' => 'required|integer',
            'id_tingkat' => 'required|integer',
            'status' => 'required',
        ]);

        // Temukan data santri
        $santri = Santri::with('user')->findOrFail($Id_santri);

        // Jika foto diubah, hapus foto lama dan simpan foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($santri->foto && file_exists(storage_path('app/public/' . $santri->foto))) {
                unlink(storage_path('app/public/' . $santri->foto));
            }

            // Upload foto baru
            $foto = $request->file('foto');
            $namaFoto = date('YmdHis') . '.' . $foto->extension();
            $foto->storeAs('public/foto', $namaFoto);

            // Simpan path foto baru
            $santri->foto = 'foto/' . $namaFoto;
        }

        // Update data santri
        $santri->update([
            'nama' => $request->input('nama'),
            'wali_santri' => $request->input('wali_santri', $santri->wali_santri),
            'Jenis_kelamin' => $request->input('Jenis_kelamin', $santri->Jenis_kelamin),
            'Tmp_lhr' => $request->input('Tmp_lhr', $santri->Tmp_lhr),
            'Tgl_lhr' => $request->input('Tgl_lhr', $santri->Tgl_lhr),
            'alamat' => $request->input('alamat', $santri->alamat),
            'Thn_masuk' => $request->input('Thn_masuk', $santri->Thn_masuk),
            'Thn_keluar' => $request->input('Thn_keluar', $santri->Thn_keluar),
            'id_kelas' => $request->input('id_kelas', $santri->id_kelas),
            'id_tingkat' => $request->input('id_tingkat', $santri->id_tingkat),
            'status' => $request->input('status', $santri->status),
        ]);

        // Update data user jika ada
        if ($santri->user) {
            // Jika email atau password berubah, update saja kolom yang relevan
            $santri->user()->update([
                'email' => $request->input('email') ?? $santri->user->email,  // Hanya update jika ada perubahan
                'password' => $request->filled('password') ? Hash::make($request->input('password')) : $santri->user->password, // Update password jika ada input
            ]);
        } else {
            // Jika user belum ada, buat user baru
            $santri->user()->create([
                'name' => $request->input('nama'),
                'email' => $request->input('email'),
                'password' => $request->filled('password') ? Hash::make($request->input('password')) : Hash::make('defaultPassword'),
            ]);
        }

        // Redirect ke halaman data santri dengan pesan sukses
        return redirect()->route('data')->with('success', 'Santri updated successfully.');
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
    // Fungsi untuk export data santri
    public function export_santri()
    {
        return Excel::download(new ExportDataSantri, 'DataSantri.xlsx');
    }
    public function exportPDF($Id_santri)
    {
        // Ambil data santri berdasarkan ID
        $santri = Santri::with(['kelas', 'tingkat'])->find($Id_santri);

        if (!$santri) {
            return redirect()->back()->with('error', 'Data santri tidak ditemukan');
        }

        // Set data yang akan dimasukkan ke PDF
        $data = [
            'title' => 'Data Santri',
            'santri' => $santri,
        ];

        // Atur konfigurasi MPDF untuk PDF
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 20,
            'margin_bottom' => 20,
            'default_font_size' => 12,
            'default_font' => 'Arial',
            'tempDir' => storage_path('app/mpdf'),  // Temp directory untuk cache
        ]);

        // Menggunakan tampilan yang sudah kita buat di resources/views
        $html = view('exports.pdf_santri_template', compact('data'))->render();

        // Set konten PDF
        $mpdf->WriteHTML($html);

        // Simpan PDF ke variabel untuk disimpan di server atau diunduh
        $pdfOutput = $mpdf->Output('', 'S');

        // Simpan PDF ke storage sementara
        $fileName = $santri->nama . $santri->id . '.pdf';
        Storage::disk('local')->put('pdfs/' . $fileName, $pdfOutput);

        // Unduh file PDF
        return response()->download(storage_path('app/pdfs/' . $fileName))->deleteFileAfterSend(true);
    }
}
