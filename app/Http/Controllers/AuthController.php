<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan form login
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    /**
     * Proses autentikasi login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi!',
            'password.required' => 'Password wajib diisi!',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))->with('sukses', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'username' => 'Username atau password yang Anda masukkan salah.',
        ])->onlyInput('username');
    }

    /**
     * Tampilkan form registrasi
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    /**
     * Proses penyimpanan user baru
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi!',
            'username.required' => 'Username wajib diisi!',
            'username.unique' => 'Username sudah digunakan, silakan pilih username lain.',
            'password.required' => 'Password wajib diisi!',
            'password.min' => 'Password minimal harus 6 karakter demi keamanan.',
            'password.confirmed' => 'Konfirmasi password tidak cocok dengan password yang dimasukkan.',
        ]);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')->with('sukses', 'Pendaftaran berhasil! Silakan login dengan akun Anda.');
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('sukses', 'Anda telah berhasil logout.');
    }
}
