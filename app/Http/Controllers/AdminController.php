<?php

namespace App\Http\Controllers;

use App\Exports\ExportData;
use App\Models\Admin;
use App\Models\Berita;
use App\Models\kelas;
use App\Models\Santri;
use App\Models\Tagihan;
use App\Models\tingkat;
use App\Models\transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $santri = Santri::all();
        $jumlahUser = $santri->count();
        return view('admin.dashboard', compact('santri', 'jumlahUser'));
    }
    public function ajuan()
    {
        return view('admin.ajuan');
    }
    public function data(Request $request)
    {
        $pagination = 5;
        $santri  = Santri::orderBy('created_at', 'desc')->paginate($pagination);
        $kelas = kelas::all();
        $tingkat = tingkat::all();
        $i = ($santri->currentPage() - 1) * $pagination;
        return view('admin.data', compact('santri', 'i', 'kelas', 'tingkat'));
    }
    public function tagihan(Request $request)
    {
        $pagination = 5;
        $santri = Santri::all();
        // Input dari request untuk pencarian tagihan
        $searchSantri = $request->input('search_santri');
        $searchTagihan = $request->input('search_tagihan');
        $kelasTagihan = $request->input('kelas_tagihan');
        $tingkatTagihan = $request->input('tingkat_tagihan');
        // Input dari request untuk pencarian transaksi
        $searchTransaksi = $request->input('search_transaksi');
        $statusTransaksi = $request->input('status_transaksi');

        // Query untuk mengambil tagihan dengan filter
        $queryTagihan = Tagihan::with('Santri');

        // Pencarian berdasarkan nama tagihan
        if ($searchTagihan) {
            $queryTagihan->where('nama_tagihan', 'like', '%' . $searchTagihan . '%');
        }

        // Filter berdasarkan nama santri
        if ($searchSantri) {
            $queryTagihan->whereHas('Santri', function ($q) use ($searchSantri) {
                $q->where('nama', 'like', '%' . $searchSantri . '%');
            });
        }

        // Filter berdasarkan kelas
        if ($kelasTagihan) {
            $queryTagihan->where('id_kelas', $kelasTagihan);
        }

        // Filter berdasarkan tingkat
        if ($tingkatTagihan) {
            $queryTagihan->where('id_tingkat', $tingkatTagihan);
        }

        // Filter berdasarkan nama santri di tagihan
        if ($searchTransaksi) {
            $queryTagihan->whereHas('santri', function ($q) use ($searchTransaksi) {
                $q->where('nama', 'like', '%' . $searchTransaksi . '%');
            });
        }

        // Ambil tagihan dengan pagination
        $tagihans = $queryTagihan->paginate(5);

        // Query untuk transaksi
        $queryTransaksi = transaksi::with('santri'); // Relasi transaksi dengan santri

        // Filter berdasarkan nama santri di transaksi
        if ($searchTransaksi) {
            $queryTransaksi->whereHas('santri', function ($q) use ($searchTransaksi) {
                $q->where('nama', 'like', '%' . $searchTransaksi . '%');
            });
        }

        // Filter berdasarkan status transaksi
        if ($statusTransaksi) {
            $queryTransaksi->where('status_transaksi', $statusTransaksi);
        }

        // Ambil transaksi dengan pagination
        $transaksis = $queryTransaksi->paginate(5);

        // Ambil data kelas dan tingkat untuk filter
        $kelas = kelas::all();
        $tingkat = tingkat::all();
        // dd($tagihans);
        // Return ke view dengan data yang sudah difilter
        return view('admin.pembayaran', compact('transaksis', 'tagihans', 'kelas', 'tingkat'))
            ->with('i', ($request->input('page', 1) - 1) * $pagination);
    }
    public function berita(request $request)
    {
        $pagination = 5;
        $beritas = Berita::orderBy('created_at', 'desc')->paginate($pagination);
        $i = ($beritas->currentPage() - 1) * $pagination;
        return view('admin.berita', compact('beritas', 'i'));
    }

    // public function create(Request $request)
    // {
    //     $admins = Admin::all();
    //     return view('admin.profile', compact('admins'));
    // }

    // public function store(Request $request)
    // {
    //     $validasi = $request->validate([
    //         'foto' => 'required|file|mimes:jpg,png,pdf|max:2048',
    //         'nama' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8'
    //     ]);
    //     $foto = $request->file('foto');
    //     $gambar_ekstensi = $foto->extension();
    //     $nama_foto = date('YmdHis') . "." . $gambar_ekstensi;
    //     $foto->move(public_path('foto'), $nama_foto);
    //     $admin = Admin::create([
    //         'nama' => $request->nama,
    //         'foto' => $nama_foto,
    //         'user_id' => 2,
    //     ]);
    //     $user = User::create([
    //         'name' => $request->nama,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'role_id' => 2,
    //     ]);
    //     Admin::create($admin, $user);
    //     // Redirect with success message
    //     return view('admin.profile')->with('success', 'Admin profile successfully created.');
    // }


    // public function profileshow(string $id_admin)
    // {
    //     $admin = Admin::find($id_admin);

    //     if (!$admin) {
    //         return redirect()->route('profilecreate')->with('error', 'Admin not found.');
    //     }

    //     return view('superadmin.profile', compact('admin'))
    //         ->with('success', 'User created successfully.');
    // }

    // public function profileedit(string $id_admin)
    // {
    //     $admin = Admin::find($id_admin);
    //     dd($admin);
    //     if (!$admin) {
    //         return redirect()->route('profile_admin')->with('error', 'Admin not found.');
    //     }
    //     return view('admin.profile', compact('admin'))->with('success', 'Berita berhasil diedit.');
    // }

    // public function update(Request $request, $id)
    // {
    //     $admin = Admin::find($id);
    //     // Validasi input
    //     $request->validate([
    //         'nama' => 'required|string|max:255',
    //         'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'email' => 'required|string|email|max:255|unique:users,email,' . $admin->user_id, // Use the user_id for validation
    //         'password' => 'nullable|string|min:8',
    //     ]);
    //     dd($admin);

    //     // Cek jika admin tidak ditemukan
    //     if (!$admin) {
    //         return redirect()->route('profile_admin')->with('error', 'Admin not found.');
    //     }

    //     // Update user yang terkait
    //     $user = $admin->user;
    //     $user->email = $request->email;
    //     if ($request->filled('password')) {
    //         $user->password = bcrypt($request->password);
    //     }
    //     $user->save();

    //     // Update data admin
    //     $admin->nama = $request->nama;

    //     if ($request->hasFile('foto')) {
    //         // Simpan file foto baru
    //         $profile = $request->file('foto');
    //         $gambar_ekstensi = $profile->extension();
    //         $nama_profile = date('YmdHis') . "." . $gambar_ekstensi;
    //         $profile->move(public_path('profile'), $nama_profile);

    //         // Hapus foto lama jika ada
    //         if ($admin->foto && file_exists(public_path('profile/' . $admin->foto))) {
    //             unlink(public_path('profile/' . $admin->foto));
    //         }

    //         // Set nama file foto baru ke admin
    //         $admin->foto = $nama_profile;
    //     }

    //     $admin->save();

    //     return back()->with('success', 'Admin profile updated successfully!');
    // }


    function export_excel()
    {
        return Excel::download(new ExportData, "DataTagihanSantri.xlsx");
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
    public function export(Request $request)
    {
        $searchTagihan = $request->input('search_tagihan');
        $kelasTagihan = $request->input('kelas_tagihan');
        $tingkatTagihan = $request->input('tingkat_tagihan');

        $queryTagihan = Tagihan::query();

        // Pencarian berdasarkan nama tagihan
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

        $tagihans = $queryTagihan->get();

        // Inisialisasi mPDF
        $mpdf = new Mpdf();

        // Buat HTML untuk export
        $html = '
        <h1>Daftar Tagihan</h1>
        <table border="1" cellspacing="0" cellpadding="10">
            <thead>
                <tr>
                    <th>Nama Tagihan</th>
                    <th>Nominal Tagihan</th>
                    <th>Waktu Tagihan</th>
                    <th>Kelas</th>
                    <th>Tingkat</th>
                </tr>
            </thead>
            <tbody>
    ';

        foreach ($tagihans as $tagihan) {
            $html .= '
            <tr>
                <td>' . $tagihan->nama_tagihan . '</td>
                <td>' . number_format($tagihan->nominal_tagihan, 0, ',', '.') . '</td>
                <td>' . $tagihan->waktu_tagihan . '</td>
                <td>' . ($tagihan->kelas->nama_kelas ?? '-') . '</td>
                <td>' . ($tagihan->tingkat->nama_tingkat ?? '-') . '</td>
            </tr>
        ';
        }

        $html .= '
            </tbody>
        </table>
    ';

        // Tulis HTML ke file PDF
        $mpdf->WriteHTML($html);

        // Output ke file
        $mpdf->Output('tagihan.pdf', 'D'); // 'D' untuk download
    }
}
