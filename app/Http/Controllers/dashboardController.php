<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use Illuminate\Support\Facades\Auth;
class dashboardController extends Controller
{
    function index() {
        $user = Auth::user();
    }
    function santri() {
        return view('santri.dashboard');
        // echo "Selamat, datang dihalaman santri";
        // echo "<h1>".Auth::user()->name."</h1>";
        // echo "<a href='/logout'>logout>></a>";
    }
    public function admin() {
        return view('admin.dashboard');
        // echo "Selamat, datang dihalaman admin";
        // echo "<h1>".Auth::user()->name."</h1>";
        // echo "<a href='/logout'>logout>></a>";
    }
    function superadmin() {
        $santri = Santri::all();
        $jumlahUser = $santri->count();
        return view('superadmin.dashboard', compact('santri', 'jumlahUser'));
        // echo "Selamat, datang dihalaman superadmin";
        // echo "<h1>".Auth::user()->name."</h1>";
        // echo "<a href='/logout'>logout>></a>";
    }
}
