<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    /**
     * Dashboard utama — satu halaman untuk semua role.
     * - Guest & User  : lihat + cari semua restoran
     * - Merchant      : lihat semua restoran + panel info restoran miliknya
     */
    public function index(Request $request)
    {
        // Query semua restoran (untuk semua role)
        $query = Restaurant::with(['category', 'reviews']);

        // Filter pencarian nama / deskripsi / alamat
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_restoran', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%')
                  ->orWhere('alamat', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Ambil semua restoran dengan rata-rata rating
        $restaurants = $query->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->orderByDesc('reviews_count')
            ->get();

        $topRestaurants = Restaurant::with('category')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->limit(4)
            ->get();

        // Ambil semua kategori untuk filter
        $categories = Category::all();

        // Data khusus merchant: restoran milik merchant yang login
        $myRestaurant = null;
        if (Auth::check() && Auth::user()->role === 'merchant') {
            $myRestaurant = Auth::user()->restaurant;
            if ($myRestaurant) {
                $myRestaurant->load(['category', 'reviews.user']);
            }
        }

        // Jika request AJAX (dari klik kategori), kembalikan potongan HTML saja
        if ($request->ajax()) {
            if ($request->get('view') === 'vertical') {
                return view('partials.restaurant_list_vertical', compact('restaurants'));
            }
            return view('partials.restaurant_list', compact('restaurants'));
        }

        // Jika route adalah pencarian, tampilkan halaman pencarian (list vertikal)
        if ($request->routeIs('user.search')) {
            return view('user.dashboard', compact('restaurants', 'categories', 'myRestaurant'));
        }

        return view('welcome', compact('restaurants', 'categories', 'topRestaurants', 'myRestaurant'));
    }

    /**
     * Detail restoran — publik, semua bisa lihat.
     */
    public function show(Restaurant $restaurant)
    {
        // Load data relasi yang dibutuhkan agar tidak terjadi N+1 query
        $restaurant->load(['category', 'reviews.user', 'menus']);

        // Cek apakah user yang login sudah pernah memberikan review untuk resto ini
        $sudahReview = false;
        if (Auth::check() && Auth::user()->role === 'user') {
            $sudahReview = $restaurant->reviews()
                ->where('user_id', Auth::id())
                ->exists();
        }

        // Ambil data distribusi rating (bintang 1-5) untuk ditampilkan di statistik
        $ratingDistribution = $restaurant->ratingDistribution();

        // Jika yang melihat adalah merchant pemilik resto ini, tandai ulasan sudah 'dilihat'
        // Kita menggunakan Session untuk mencatat waktu kunjungan terakhir karena dilarang memodifikasi struktur Database
        if (Auth::check() && Auth::user()->role === 'merchant' && Auth::user()->id === $restaurant->id_merchant) {
            session(['last_viewed_reviews_at_' . $restaurant->id_restoran => now()]);
        }

        return view('user.restaurant', compact('restaurant', 'sudahReview', 'ratingDistribution'));
    }

    /**
     * Form tambah restoran (merchant yang belum punya restoran).
     */
    public function create()
    {
        if (Auth::user()->restaurant) {
            return redirect()->route('user.dashboard')
                ->with('info', 'Kamu sudah punya restoran. Edit lewat panel di dashboard.');
        }
        $categories = Category::all();
        return view('merchant.create', compact('categories'));
    }

    /**
     * Simpan restoran baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_restoran' => 'required|max:150',
            'category_id'   => 'required|exists:categories,id',
            'deskripsi'     => 'nullable|string',
            'alamat'        => 'required|string',
            'kontak'        => 'required|max:20',
            'gmaps_link'    => 'nullable|max:2048',
            'gambar'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'hari_operasional' => 'required|array',
            'jam_buka'         => 'required|string',
            'jam_tutup'        => 'required|string',
            'harga_min'        => 'required|numeric',
            'harga_max'        => 'required|numeric',
        ]);

        $data = [
            'id_merchant'   => Auth::id(),
            'category_id'   => $request->category_id,
            'nama_restoran' => $request->nama_restoran,
            'deskripsi'     => $request->deskripsi,
            'alamat'        => $request->alamat,
            'kontak'        => $request->kontak,
            'gmaps_link'    => $request->gmaps_link,
            'hari_operasional' => implode(', ', $request->hari_operasional),
            'jam_operasional'  => $request->jam_buka . ' - ' . $request->jam_tutup,
            'range_harga'      => $request->harga_min . ' - ' . $request->harga_max,
        ];

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('restaurants', 'public');
            $data['gambar'] = $path;
        }

        Restaurant::create($data);

        // Update role flags di DB agar sinkron
        Auth::user()->update([
            'is_merchant' => true,
            'role' => 'merchant' // fallback untuk kompatibilitas lama
        ]);
        
        // Set session active role
        session(['active_role' => 'merchant']);

        return redirect()->route('merchant.manage')
            ->with('success', 'Restoran berhasil didaftarkan! Selamat datang di panel Merchant.');
    }

    /**
     * Form edit restoran (merchant).
     */
    public function edit()
    {
        $restaurant = Auth::user()->restaurant;
        if (!$restaurant) {
            return redirect()->route('merchant.create');
        }
        $categories = Category::all();
        return view('merchant.edit', compact('restaurant', 'categories'));
    }

    /**
     * Update data restoran.
     */
    public function update(Request $request)
    {
        $restaurant = Auth::user()->restaurant;

        $request->validate([
            'nama_restoran' => 'required|max:150',
            'category_id'   => 'required|exists:categories,id',
            'deskripsi'     => 'nullable|string',
            'alamat'        => 'required|string',
            'kontak'        => 'required|max:20',
            'gmaps_link'    => 'nullable|max:2048',
            'gambar'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'hari_operasional' => 'required|array',
            'jam_buka'         => 'required|string',
            'jam_tutup'        => 'required|string',
            'harga_min'        => 'required|numeric',
            'harga_max'        => 'required|numeric',
        ]);

        $data = [
            'category_id'   => $request->category_id,
            'nama_restoran' => $request->nama_restoran,
            'deskripsi'     => $request->deskripsi,
            'alamat'        => $request->alamat,
            'kontak'        => $request->kontak,
            'gmaps_link'    => $request->gmaps_link,
            'hari_operasional' => implode(', ', $request->hari_operasional),
            'jam_operasional'  => $request->jam_buka . ' - ' . $request->jam_tutup,
            'range_harga'      => $request->harga_min . ' - ' . $request->harga_max,
        ];

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($restaurant->gambar && \Illuminate\Support\Facades\Storage::disk('public')->exists($restaurant->gambar)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($restaurant->gambar);
            }
            $path = $request->file('gambar')->store('restaurants', 'public');
            $data['gambar'] = $path;
        }

        $restaurant->update($data);

        return redirect()->route('restaurant.show', $restaurant->id_restoran)
            ->with('success', 'Data restoran berhasil diperbarui!');
    }

    /**
     * Redirect lama merchant.dashboard ke dashboard utama.
     * Biar link lama tidak 404.
     */
    public function merchantDashboard()
    {
        return redirect()->route('user.dashboard');
    }
}
