<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Santri;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    function index()
    {
        $user = Auth::user();
    }
    function santri()
    {
        $santri = Santri::all();
        $jumlahUser = $santri->count();
        return view('santri.dashboard', compact('santri', 'jumlahUser'));
    }
    public function admin()
    {
        $santri = Santri::all();
        $jumlahUser = $santri->count();
        return view('admin.dashboard', compact('santri', 'jumlahUser'));
        // echo "Selamat, datang dihalaman admin";
        // echo "<h1>".Auth::user()->name."</h1>";
        // echo "<a href='/logout'>logout>></a>";
    }
    function superadmin()
    {
        $santri = Santri::all();
        $jumlahUser = $santri->count();
        $admin = admin::where('user_id', Auth::id())->first();
        return view('superadmin.dashboard', compact('admin', 'santri', 'jumlahUser'));
    }
}
