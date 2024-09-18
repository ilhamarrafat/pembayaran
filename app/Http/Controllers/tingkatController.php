<?php

namespace App\Http\Controllers;

use App\Models\tingkat;
use Illuminate\Http\Request;

class tingkatController extends Controller
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
        $tingkat = tingkat::all();
        return view('superadmin.tingkat', compact('tingkat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'tingkat',
        ]);
        $tingkat = tingkat::create([
            'tingkat' => $validate(['tingkat'])
        ]);
        return redirect('superadmin.tingkat')->with('tingkat berhasil ditambahkan');
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
        $tingkat = tingkat::findOrFail($id);
        $tingkat->delete();
        return redirect('superadmin.data')
            ->with('success', 'tingkat deleted successfully.');
    }
}
