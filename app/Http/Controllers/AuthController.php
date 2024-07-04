<?php
namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Tetapkan peran sebagai user
        ]);

        return redirect()->route('login')->with('success', 'Registration successful, please login.');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ],
        [
            'email.required' => 'email wajib diisi',
            'password.required' => 'email wajib diisi',
        ]
    );

        $infologin=[
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($infologin))
         {
           if(Auth::user()->role=='santri'){
            return redirect('/dashboard/santri');
        } else if (Auth::user()->role=='admin'){
            return redirect('/dashboard/admin');
        } else if (Auth::user()->role=='superadmin'){
            return redirect('/dashboard/superadmin');
        } 
    }
        else{
            return redirect('')->withErrors('email dan password salah')->withInput();
        }
    }
            function logout()
    {
        Auth::logout();
        return redirect('');
    }

}