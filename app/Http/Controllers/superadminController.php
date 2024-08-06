<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class superadminController extends Controller
{
    // public function index (){
    //     return view('superadmin.data');
    // }
    public function ajuan (){
        return view('superadmin.ajuan');
    }
    public function bayar (){
        return view('superadmin.pembayaran');
    }
    public function santri(){
        return view('superadmin.csantri');
    }
}
