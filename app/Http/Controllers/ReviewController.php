<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Simpan review baru
    public function store(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'Rating wajib dipilih.',
            'rating.min'      => 'Rating minimal 1 bintang.',
            'rating.max'      => 'Rating maksimal 5 bintang.',
        ]);

        // Cek apakah user sudah pernah review restoran ini
        $sudahReview = Review::where('user_id', Auth::id())
            ->where('restaurant_id', $restaurant->id)
            ->exists();

        if ($sudahReview) {
            return back()->withErrors(['rating' => 'Kamu sudah pernah mereview restoran ini.']);
        }

        Review::create([
            'user_id'       => Auth::id(),
            'restaurant_id' => $restaurant->id,
            'rating'        => $request->rating,
            'komentar'      => $request->komentar,
        ]);

        return back()->with('success', 'Review berhasil ditambahkan!');
    }

    // Hapus review (oleh user yang bersangkutan)
    public function destroy(Review $review)
    {
        // Pastikan hanya pemilik review yang bisa hapus
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $review->delete();

        return back()->with('success', 'Review berhasil dihapus.');
    }
}
