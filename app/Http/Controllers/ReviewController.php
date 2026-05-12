<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Tampilkan halaman form tulis ulasan
    public function create(Restaurant $restaurant)
    {
        // Hanya user yang sudah login dan belum review yang bisa akses
        if (!Auth::check() || Auth::user()->role !== 'user') {
            return redirect()->route('login');
        }

        $sudahReview = Review::where('user_id', Auth::id())
            ->where('restaurant_id', $restaurant->id_restoran)
            ->exists();

        if ($sudahReview) {
            return redirect()->route('restaurant.show', $restaurant->id_restoran)
                ->with('info', 'Kamu sudah pernah mereview restoran ini.');
        }

        return view('user.review', compact('restaurant'));
    }

    // Simpan review baru
    public function store(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
            'gambar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'rating.required' => 'Rating wajib dipilih.',
            'gambar.image'    => 'File harus berupa gambar.',
            'gambar.mimes'    => 'Format gambar harus JPG, JPEG, atau PNG.',
        ]);

        // Cek duplikat review
        $sudahReview = Review::where('user_id', Auth::id())
            ->where('restaurant_id', $restaurant->id_restoran)
            ->exists();

        if ($sudahReview) {
            return back()->withErrors(['rating' => 'Kamu sudah pernah mereview restoran ini.']);
        }

        // Upload gambar jika ada
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('reviews', 'public');
        }

        Review::create([
            'user_id'       => Auth::id(),
            'restaurant_id' => $restaurant->id_restoran,
            'rating'        => $request->rating,
            'komentar'      => $request->komentar,
            'gambar'        => $gambarPath,
        ]);

        return redirect()->route('restaurant.show', $restaurant->id_restoran)
            ->with('success', 'Ulasan berhasil ditambahkan!');
    }

    // Hapus review
    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        // Hapus file gambar jika ada
        if ($review->gambar) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($review->gambar);
        }

        $review->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
