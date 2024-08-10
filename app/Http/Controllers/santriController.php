<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class santriController extends Controller
{
    public function index(Request $request)
    {
        return view('santri.dashboard');
    }
    public function pembayaran(Request $request)
    {
        return view('santri.pembayaran');
    }
}
