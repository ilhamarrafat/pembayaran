<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class dashboardController extends Controller
{
    function index() {
        $user = Auth::user();
    }
    function santri() {
        return view('dashboard.santri');
        // echo "Selamat, datang dihalaman santri";
        // echo "<h1>".Auth::user()->name."</h1>";
        // echo "<a href='/logout'>logout>></a>";
    }
    public function admin() {
        return view('dashboard.admin');
        // echo "Selamat, datang dihalaman admin";
        // echo "<h1>".Auth::user()->name."</h1>";
        // echo "<a href='/logout'>logout>></a>";
    }
    function superadmin() {
        return view('superadmin.dashboard');
        // echo "Selamat, datang dihalaman superadmin";
        // echo "<h1>".Auth::user()->name."</h1>";
        // echo "<a href='/logout'>logout>></a>";
    }
}
