<?php

namespace App\Http\Controllers;

use App\Models\ajuan;
use Illuminate\Http\Request;

class telatController extends Controller
{
    public function index()
    {
        return view('santri.cajuan');
    }
    public function create()
    {
        $ajuan = ajuan::all();
        return view('santri.cajuan');
    }
}
