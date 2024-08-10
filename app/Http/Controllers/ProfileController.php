<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $admins = Admin::all();
        return view('superadmin.profile', compact('admins'));
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
        $validasi = $request->validate([
            'foto' => 'required|file|mimes:jpg,png,pdf|max:2048',
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);
        $foto = $request->file('foto');
        $gambar_ekstensi = $foto->extension();
        $nama_foto = date('YmdHis') . "." . $gambar_ekstensi;
        $foto->move(public_path('foto'), $nama_foto);
        // $Data = ([
        //     'user_id' => $request->user_id,
        //     'nama' => $request->input('nama'),
        //     'email' => $request->input('email'),
        //     'password' => $request->input('password')
        // ]);
        $admin = Admin::create([
            'nama' => $request->nama,
            'foto' => $nama_foto,
            'user_id' => 1, // Tetapkan peran sebagai user
        ]);
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 1,
        ]);
        // $admin = Admin::all();
        // $user = User::all();
        // dd($user, $admin);
        Admin::create($admin, $user);
        return redirect('/profile')->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_admin)
    {
        $admin = Admin::find($id_admin);

        if (!$admin) {
            return redirect()->route('profile.index')->with('error', 'Admin not found.');
        }

        return view('superadmin.profile', compact('admin'))
            ->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id_admin)
    {
        $admin = Admin::find($id_admin);
        dd($admin);
        if (!$admin) {
            return redirect()->route('profile.index')->with('error', 'Admin not found.');
        }
        return view('superadmin.profile', compact('admin'))
            ->with('success', 'Berita berhasil diedit.');
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
            'password' => 'nullable|string|min:8', // Validasi password
        ]);
        // Ambil data admin yang akan diupdate
        $admin = Admin::find($id_admin);
        // dd($admin);

        // Cek jika admin tidak ditemukan
        if (!$admin) {
            return redirect()->route('admin.index')->with('error', 'Admin not found.');
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
        return redirect()->route('profile', $admin->id_admin)->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
