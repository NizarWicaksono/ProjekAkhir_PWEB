<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 1. Tampilkan Form Register
    public function showRegister()
    {
        return view('auth.register');
    }

    // 2. Proses Register
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // confirmed butuh input name="password_confirmation" di form
        ]);

        // Simpan ke Database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password wajib di-hash/enkripsi
        ]);

        // Langsung login setelah register (opsional)
        // Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // 3. Tampilkan Form Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // 4. Proses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
        
            // CEK ROLE USER DISINI
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard'); // Lempar ke Admin
            }
        
            return redirect()->intended('dashboard'); // Lempar ke User Biasa
        }
    
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // 5. Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
