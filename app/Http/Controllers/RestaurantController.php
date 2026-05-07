<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    // ==========================================
    // USER: Dashboard - lihat & cari restoran
    // ==========================================
    public function index(Request $request)
    {
        $query = Restaurant::with(['category', 'reviews']);

        // Filter pencarian nama restoran
        if ($request->filled('search')) {
            $query->where('nama_restoran', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Semua restoran
        $restaurants = $query->latest()->get();

        // Rekomendasi: 5 restoran dengan rata-rata rating tertinggi
        $rekomendasi = Restaurant::with(['category', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->take(5)
            ->get();

        // Semua kategori untuk filter
        $categories = Category::all();

        return view('user.dashboard', compact('restaurants', 'rekomendasi', 'categories'));
    }

    // USER: Halaman detail restoran
    public function show(Restaurant $restaurant)
    {
        $restaurant->load(['category', 'reviews.user']);

        // Cek apakah user sudah pernah review restoran ini
        $sudahReview = $restaurant->reviews()
            ->where('user_id', Auth::id())
            ->exists();

        return view('user.restaurant', compact('restaurant', 'sudahReview'));
    }

    // ==========================================
    // MERCHANT: Dashboard
    // ==========================================
    public function merchantDashboard()
    {
        $restaurant = Auth::user()->restaurant;
        return view('merchant.dashboard', compact('restaurant'));
    }

    // MERCHANT: Form tambah restoran
    public function create()
    {
        // Jika merchant sudah punya restoran, langsung ke edit
        if (Auth::user()->restaurant) {
            return redirect()->route('merchant.edit')
                ->with('info', 'Kamu sudah punya restoran. Silakan edit di sini.');
        }

        $categories = Category::all();
        return view('merchant.create', compact('categories'));
    }

    // MERCHANT: Simpan restoran baru
    public function store(Request $request)
    {
        $request->validate([
            'category_id'   => 'required|exists:categories,id',
            'nama_restoran' => 'required|max:150',
            'deskripsi'     => 'nullable|string',
            'alamat'        => 'required|string',
            'kontak'        => 'required|max:20',
            'gmaps_link'    => 'nullable|url|max:2048',
            'gambar'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'category_id.required'   => 'Pilih kategori restoran.',
            'nama_restoran.required' => 'Nama restoran wajib diisi.',
            'alamat.required'        => 'Alamat wajib diisi.',
            'kontak.required'        => 'Kontak wajib diisi.',
            'gmaps_link.url'         => 'Link Google Maps tidak valid.',
            'gambar.image'           => 'File harus berupa gambar.',
            'gambar.max'             => 'Ukuran gambar maksimal 2MB.',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('restaurants', 'public');
        }

        Restaurant::create([
            'user_id'       => Auth::id(),
            'category_id'   => $request->category_id,
            'nama_restoran' => $request->nama_restoran,
            'deskripsi'     => $request->deskripsi,
            'alamat'        => $request->alamat,
            'kontak'        => $request->kontak,
            'gmaps_link'    => $request->gmaps_link,
            'gambar'        => $gambarPath,
        ]);

        return redirect()->route('merchant.dashboard')
            ->with('success', 'Restoran berhasil ditambahkan!');
    }

    // MERCHANT: Form edit restoran
    public function edit()
    {
        $restaurant = Auth::user()->restaurant;

        if (!$restaurant) {
            return redirect()->route('merchant.create')
                ->with('info', 'Kamu belum punya restoran. Tambahkan dulu.');
        }

        $categories = Category::all();
        return view('merchant.edit', compact('restaurant', 'categories'));
    }

    // MERCHANT: Update restoran
    public function update(Request $request)
    {
        $restaurant = Auth::user()->restaurant;

        $request->validate([
            'category_id'   => 'required|exists:categories,id',
            'nama_restoran' => 'required|max:150',
            'deskripsi'     => 'nullable|string',
            'alamat'        => 'required|string',
            'kontak'        => 'required|max:20',
            'gmaps_link'    => 'nullable|url|max:2048',
            'gambar'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'category_id.required'   => 'Pilih kategori restoran.',
            'nama_restoran.required' => 'Nama restoran wajib diisi.',
            'alamat.required'        => 'Alamat wajib diisi.',
            'kontak.required'        => 'Kontak wajib diisi.',
            'gmaps_link.url'         => 'Link Google Maps tidak valid.',
            'gambar.image'           => 'File harus berupa gambar.',
            'gambar.max'             => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Ganti gambar jika ada upload baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($restaurant->gambar) {
                Storage::disk('public')->delete($restaurant->gambar);
            }
            $restaurant->gambar = $request->file('gambar')->store('restaurants', 'public');
        }

        $restaurant->update([
            'category_id'   => $request->category_id,
            'nama_restoran' => $request->nama_restoran,
            'deskripsi'     => $request->deskripsi,
            'alamat'        => $request->alamat,
            'kontak'        => $request->kontak,
            'gmaps_link'    => $request->gmaps_link,
            'gambar'        => $restaurant->gambar,
        ]);

        return redirect()->route('merchant.dashboard')
            ->with('success', 'Restoran berhasil diperbarui!');
    }
}
