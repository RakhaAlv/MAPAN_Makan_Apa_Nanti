<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerchantController extends Controller
{
    /**
     * Tampilan Kelola Restoran (Dashboard Menu & Ulasan).
     */
    public function manage()
    {
        $user = Auth::user();
        $restaurant = $user->restaurant;

        if (!$restaurant) {
            return redirect()->route('merchant.create');
        }

        $restaurant->load(['menus', 'reviews.user']);
        
        $totalMenu = $restaurant->menus->count();
        $averageRating = $restaurant->averageRating();
        $totalReviews = $restaurant->reviews->count();
        
        // Ambil waktu terakhir merchant melihat detail resto (lewat session)
        // Jika belum pernah lihat, anggap ulasan 7 hari terakhir sebagai 'baru'
        $lastViewed = session('last_viewed_reviews_at_' . $restaurant->id_restoran, now()->subDays(7));
        $newReviewsCount = $restaurant->reviews()->where('created_at', '>', $lastViewed)->count();

        $makanan = $restaurant->menus->where('kategori', 'Makanan');
        $minuman = $restaurant->menus->where('kategori', 'Minuman');

        return view('merchant.manage', compact(
            'user', 
            'restaurant', 
            'totalMenu', 
            'averageRating', 
            'totalReviews', 
            'newReviewsCount',
            'makanan',
            'minuman'
        ));
    }

    /**
     * Tampilan Profil Merchant (Kosong untuk sementara).
     */
    public function profile()
    {
        return view('merchant.profile');
    }

    /**
     * Simpan menu baru.
     */
    public function storeMenu(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga'     => 'required|numeric',
            'kategori'  => 'required|in:Makanan,Minuman',
        ]);

        $restaurant = Auth::user()->restaurant;

        Menu::create([
            'restaurant_id' => $restaurant->id_restoran,
            'nama_menu'     => $request->nama_menu,
            'deskripsi'     => $request->deskripsi,
            'harga'         => $request->harga,
            'kategori'      => $request->kategori,
        ]);

        return back()->with('success', 'Menu berhasil ditambahkan!');
    }

    /**
     * Update menu.
     */
    public function updateMenu(Request $request, Menu $menu)
    {
        // Pastikan menu milik restoran merchant ini
        if ($menu->restaurant_id !== Auth::user()->restaurant->id_restoran) {
            abort(403);
        }

        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga'     => 'required|numeric',
            'kategori'  => 'required|in:Makanan,Minuman',
        ]);

        $menu->update($request->all());

        return back()->with('success', 'Menu berhasil diperbarui!');
    }

    /**
     * Hapus menu.
     */
    public function destroyMenu(Menu $menu)
    {
        if ($menu->restaurant_id !== Auth::user()->restaurant->id_restoran) {
            abort(403);
        }

        $menu->delete();

        return back()->with('success', 'Menu berhasil dihapus!');
    }
}
