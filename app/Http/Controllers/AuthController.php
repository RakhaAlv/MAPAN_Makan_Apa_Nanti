<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilan pemilihan role sebelum registrasi.
     */
    public function showRegisterRole()
    {
        return view('auth.register_select_role');
    }

    /**
     * Tampilan form registrasi sesuai role.
     */
    public function showRegister($role = 'user')
    {
        $categories = Category::all();
        return view('auth.register', compact('role', 'categories'));
    }

    /**
     * Proses registrasi User baru.
     */
    public function register(Request $request)
    {
        // Validasi umum (sama untuk semua role)
        $rules = [
            'username'      => 'required|max:100|unique:users,username',
            'nama_pengguna' => 'required|max:150',
            'email'         => 'required|email|max:255|unique:users,email',
            'password'      => 'required|min:6|confirmed',
            'role'          => 'required|in:user,merchant',
        ];

        $messages = [
            'username.unique' => 'Username sudah digunakan.',
            'email.unique'    => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];

        // Validasi tambahan merchant (sesuai form mockup)
        if ($request->role === 'merchant') {
            $rules['nama_restoran'] = 'required|max:150';
            $rules['category_id']   = 'required|exists:categories,id';
            $rules['alamat']        = 'required|string';
            $rules['kontak']        = 'required|max:20';
            $rules['deskripsi']     = 'nullable|string';
            $rules['gmaps_link']    = 'required|max:2048';
            $rules['gambar']        = 'nullable|image|mimes:jpg,jpeg,png|max:2048';
            $rules['hari_operasional'] = 'required|array';
            $rules['jam_buka']      = 'required|string';
            $rules['jam_tutup']     = 'required|string';
            $rules['harga_min']     = 'required|numeric';
            $rules['harga_max']     = 'required|numeric';

            $messages['nama_restoran.required'] = 'Nama restoran wajib diisi.';
            $messages['category_id.required']   = 'Kategori wajib dipilih.';
            $messages['category_id.exists']     = 'Kategori tidak valid.';
            $messages['alamat.required']        = 'Alamat wajib diisi.';
            $messages['kontak.required']        = 'No. kontak wajib diisi.';
            $messages['gmaps_link.required']    = 'Link Maps wajib diisi.';
            $messages['hari_operasional.required'] = 'Hari operasional wajib dipilih.';
            $messages['jam_buka.required']      = 'Jam buka wajib diisi.';
            $messages['jam_tutup.required']     = 'Jam tutup wajib diisi.';
            $messages['harga_min.required']     = 'Harga minimal wajib diisi.';
            $messages['harga_max.required']     = 'Harga maksimal wajib diisi.';
        }

        $request->validate($rules, $messages);

        // Buat user
        $user = User::create([
            'username'      => $request->username,
            'nama_pengguna' => $request->nama_pengguna,
            'email'         => $request->email,
            'password'      => $request->password,
            'role'          => $request->role,
        ]);

        // Jika merchant, langsung buat restoran
        if ($request->role === 'merchant') {
            $data_restoran = [
                'id_merchant'   => $user->id,
                'category_id'   => $request->category_id,
                'nama_restoran' => $request->nama_restoran,
                'deskripsi'     => $request->deskripsi,
                'alamat'        => $request->alamat,
                'hari_operasional' => implode(', ', $request->hari_operasional),
                'jam_operasional'  => $request->jam_buka . ' - ' . $request->jam_tutup,
                'range_harga'      => $request->harga_min . ' - ' . $request->harga_max,
                'kontak'        => $request->kontak,
                'gmaps_link'    => $request->gmaps_link,
            ];

            if ($request->hasFile('gambar')) {
                $path = $request->file('gambar')->store('restaurants', 'public');
                $data_restoran['gambar'] = $path;
            }

            Restaurant::create($data_restoran);
        }

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            // Redirect langsung berdasarkan role
            $user = Auth::user();
            if ($user->role === 'merchant') {
                return redirect()->route('merchant.manage');
            }
            return redirect()->route('home');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home');
    }
}
