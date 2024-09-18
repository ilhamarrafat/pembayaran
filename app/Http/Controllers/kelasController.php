<?php

namespace App\Http\Controllers;

use App\Models\kelas;
use App\Models\tingkat;
use Illuminate\Http\Request;

class kelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = kelas::all();
        return view('superadmin.kelas', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'kelas',
        ]);
        $kelas = kelas::create([
            'kelas' => $validate(['kelas'])
        ]);
        return redirect('superadmin.kelas')->with('kelas berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kelas = kelas::findOrFail($id);
        $kelas->delete();
        return redirect('superadmin.data')
            ->with('success', 'kelas deleted successfully.');
    }
}
