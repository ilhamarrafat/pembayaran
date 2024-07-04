<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class dashboardController extends Controller
{
    function index() {
        echo "Selamat, datang dihalaman";
        echo "<h1>".Auth::user()->name."</h1>";
        echo "<a href='/logout'>logout>></a>";
    }
    function santri() {
        echo "Selamat, datang dihalaman santri";
        echo "<h1>".Auth::user()->name."</h1>";
        echo "<a href='/logout'>logout>></a>";
    }
    function admin() {
        echo "Selamat, datang dihalaman admin";
        echo "<h1>".Auth::user()->name."</h1>";
        echo "<a href='/logout'>logout>></a>";
    }
    function superadmin() {
        echo "Selamat, datang dihalaman superadmin";
        echo "<h1>".Auth::user()->name."</h1>";
        echo "<a href='/logout'>logout>></a>";
    }
}
