<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use App\Models\Bayar;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 3, // Tetapkan peran sebagai user
        ]);


        $santri = Santri::create([
            'user_id' => $user->id,
            'nama' => $request->name,
        ]);
        // $user = User::all();
        // $santri = Santri::all();
        // dd($user, $santri);
        auth()->login($user);

        return redirect()->route('login')->with('success', 'Registration successful, please login.');
    }

    public function showlogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required',
                'password' => 'required',
            ],
            [
                'email.required' => 'email wajib diisi',
                'password.required' => 'email wajib diisi',
            ]
        );

        $infologin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($infologin)) {
            if (Auth::user()->role_id == '3') {
                return redirect('/dashboard/santri');
            } else if (Auth::user()->role_id == '2') {
                return redirect('/dashboard/admin');
            } else if (Auth::user()->role_id == '1') {
                return redirect('/dashboard/superadmin');
            }
        } else {
            return redirect('')->withErrors('email dan password salah')->withInput();
        }
    }
    function logout()
    {
        Auth::logout();
        return redirect('');
    }
}
