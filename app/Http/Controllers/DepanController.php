<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class DepanController extends Controller
{
    public function index(Request $request)
    {
        $pagination = 5;
        $beritas = Berita::orderBy('created_at', 'desc')->paginate($pagination);
        $i = ($beritas->currentPage() - 1) * $pagination;
        return view('tampilan.master', compact('beritas', 'i'));
    }
}
