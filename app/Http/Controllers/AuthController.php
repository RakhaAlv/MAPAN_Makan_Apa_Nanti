<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Tampilkan halaman register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        $request->validate([
            'username'      => 'required|unique:users|max:100',
            'nama_pengguna' => 'required|max:150',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|min:6|confirmed',
            'role'          => 'required|in:user,merchant',
        ], [
            'username.required'      => 'Username wajib diisi.',
            'username.unique'        => 'Username sudah dipakai.',
            'nama_pengguna.required' => 'Nama pengguna wajib diisi.',
            'email.required'         => 'Email wajib diisi.',
            'email.unique'           => 'Email sudah terdaftar.',
            'password.required'      => 'Password wajib diisi.',
            'password.min'           => 'Password minimal 6 karakter.',
            'password.confirmed'     => 'Konfirmasi password tidak cocok.',
            'role.required'          => 'Pilih jenis akun.',
        ]);

        User::create([
            'username'      => $request->username,
            'nama_pengguna' => $request->nama_pengguna,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'role'          => $request->role,
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    // Tampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            // Arahkan berdasarkan role
            if (Auth::user()->role === 'merchant') {
                return redirect()->route('merchant.dashboard');
            }

            return redirect()->route('user.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
