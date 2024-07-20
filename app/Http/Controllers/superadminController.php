<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class superadminController extends Controller
{
    public function index (){
        return view('superadmin.data');
    }
}
