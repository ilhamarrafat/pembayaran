<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $admin = admin::where('user_id', Auth::id())->first();
        // dd($admin);
        return view('superadmin.profile', compact('admin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $validasi = $request->validate([
            'foto' => 'required|file|mimes:jpg,png,pdf|max:2048',
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        // Simpan user
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 1, // Sesuaikan role jika perlu
        ]);

        // Simpan foto
        $foto = $request->file('foto');
        $nama_foto = date('YmdHis') . '.' . $foto->extension();
        $foto->move(public_path('foto'), $nama_foto);

        // Simpan admin dengan user_id dari user yang baru saja dibuat
        Admin::create([
            'nama' => $request->nama,
            'foto' => $nama_foto,
            'user_id' => $user->id, // Menggunakan id dari user yang baru dibuat
        ]);

        return redirect('/profile')->with('success', 'Admin berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id_admin)
    {
        $admin = admin::where('user_id', Auth::id())->first();
        dd($admin);
        return view('superadmin.profile', compact('admin'))
            ->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id_admin)
    {
        $user = Auth::user();

        // Ambil admin berdasarkan user_id
        $admin = Admin::where('user_id', $user->id)->first();

        // Jika admin tidak ditemukan
        if (!$admin) {
            return redirect()->route('profile')->with('error', 'Admin not found.');
        }

        return view('superadmin.profile', compact('admin'))
            ->with('success', 'Profile berhasil diedit.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_admin)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
            'email' => 'required|string|email|max:255|unique:users,email,' . $id_admin . ',id', // Validasi email
            'password' => 'nullable|string|min:8|confirmed', // Validasi password dan konfirmasi
        ]);

        // Ambil data admin yang akan diupdate
        $admin = Admin::find($id_admin);

        // Cek jika admin tidak ditemukan
        if (!$admin) {
            return redirect()->route('profile')->with('error', 'Admin not found.');
        }

        // Update user yang terkait
        $user = $admin->user;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        // Update data admin
        $admin->nama = $request->nama;

        if ($request->hasFile('foto')) {
            // Simpan file foto baru
            $profile = $request->file('foto');
            $gambar_ekstensi = $profile->extension();
            $nama_profile = date('YmdHis') . "." . $gambar_ekstensi;
            $profile->move(public_path('profile'), $nama_profile);

            // Hapus foto lama jika ada
            if ($admin->foto && file_exists(public_path('profile/' . $admin->foto))) {
                unlink(public_path('profile/' . $admin->foto));
            }

            // Set nama file foto baru ke admin
            $admin->foto = $nama_profile;
        }

        $admin->save();
        return redirect()->route('profile', $admin->id_admin)->with('success', 'Profile updated successfully.');
    }





    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
