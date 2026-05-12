<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil (Unified for User & Merchant).
     */
    public function index()
    {
        $user = Auth::user();
        $reviews = [];

        // Jika role adalah user, ambil riwayat ulasan yang pernah ia tulis
        if ($user->role === 'user') {
            $reviews = Review::where('user_id', $user->id)
                ->with('restaurant')
                ->latest()
                ->get();
        } 
        // Jika role adalah merchant, ambil ulasan yang masuk ke restorannya
        else if ($user->role === 'merchant') {
            $restaurant = $user->restaurant;
            if ($restaurant) {
                $reviews = Review::where('restaurant_id', $restaurant->id_restoran)
                    ->with('user')
                    ->latest()
                    ->get();
            }
        }

        return view('user.profile', compact('user', 'reviews'));
    }

    /**
     * Update informasi profil seperti Nama Lengkap dan Username.
     * Menggunakan validasi 'unique' untuk username kecuali untuk user itu sendiri.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'username'      => 'required|string|max:255|unique:users,username,' . $user->id,
        ]);

        $user->update([
            'nama_pengguna' => $request->nama_pengguna,
            'username'      => $request->username,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update password user.
     * Menggunakan rule 'current_password' untuk memastikan user tahu password lamanya.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password'         => ['required', 'confirmed', Password::defaults()],
        ], [
            'current_password.current_password' => 'Password saat ini salah.',
            'password.confirmed'                => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }
}
