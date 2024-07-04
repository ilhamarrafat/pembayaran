<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
         $request->validate([
            'email' => 'required',
            'password' => 'required'
        ],[
            'email.required' => 'Email belum dimasukkan',
            'password.required'=>'Password belum dimasukkan'
        ]
    );
    if (Auth::attempt($request->only('email', 'password'))) {
        return redirect()->intended('/dashboard');
    }
    else{
        return redirect('')->withErrors('email dan password tidak sesuai!')->withInput();
    }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
     
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('/');
    }
}
