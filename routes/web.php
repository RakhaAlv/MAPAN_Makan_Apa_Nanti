<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ==========================================
// PUBLIK — bisa diakses tanpa login
// ==========================================
Route::get('/', [RestaurantController::class, 'index'])->name('home');

// Dashboard — SATU halaman untuk semua (guest, user, merchant)
Route::get('/search', [RestaurantController::class, 'index'])
    ->name('user.search');

// Detail restoran — publik
Route::get('/restoran/{restaurant}', [RestaurantController::class, 'show'])
    ->name('restaurant.show');

// ==========================================
// AUTH
// ==========================================
Route::get('/register', [AuthController::class, 'showRegisterRole'])->name('register.select');
Route::get('/register/{role}', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ==========================================
// USER — hanya role = user
// ==========================================
Route::middleware(['auth', 'role:user'])->group(function () {
    // Halaman form tulis ulasan
    Route::get('/restoran/{restaurant}/review', [ReviewController::class, 'create'])
        ->name('reviews.create');
    // Submit review
    Route::post('/restoran/{restaurant}/review', [ReviewController::class, 'store'])
        ->name('reviews.store');
    // Hapus review
    Route::delete('/review/{review}', [ReviewController::class, 'destroy'])
        ->name('reviews.destroy');

    // Profil User
    Route::get('/user/profile', [ProfileController::class, 'index'])
        ->name('user.profile');
    
    // Password Update User
    Route::post('/user/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('user.profile.password');

    // Profile Info Update User
    Route::post('/user/profile/update', [ProfileController::class, 'update'])
        ->name('user.profile.update');
});

// ==========================================
// MERCHANT — hanya role = merchant
// ==========================================
Route::middleware(['auth', 'role:merchant'])->group(function () {
    // Kelola Restoran (Dashboard Menu & Ulasan)
    Route::get('/merchant/manage', [MerchantController::class, 'manage'])
        ->name('merchant.manage');

    // Profil Merchant (Sekarang pakai ProfileController)
    Route::get('/merchant/profile', [ProfileController::class, 'index'])
        ->name('merchant.profile');

    // Password Update Merchant
    Route::post('/merchant/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('merchant.profile.password');

    // Profile Info Update Merchant
    Route::post('/merchant/profile/update', [ProfileController::class, 'update'])
        ->name('merchant.profile.update');

    // Menu Management
    Route::post('/merchant/menu', [MerchantController::class, 'storeMenu'])
        ->name('menu.store');
    Route::put('/merchant/menu/{menu}', [MerchantController::class, 'updateMenu'])
        ->name('menu.update');
    Route::delete('/merchant/menu/{menu}', [MerchantController::class, 'destroyMenu'])
        ->name('menu.destroy');

    // Redirect /merchant/dashboard ke kelola restoran
    Route::get('/merchant/dashboard', [MerchantController::class, 'manage'])
        ->name('merchant.dashboard');

    // Tambah restoran
    Route::get('/merchant/restoran/tambah',  [RestaurantController::class, 'create'])
        ->name('merchant.create');
    Route::post('/merchant/restoran', [RestaurantController::class, 'store'])
        ->name('merchant.store');

    // Edit restoran
    Route::get('/merchant/restoran/edit', [RestaurantController::class, 'edit'])
        ->name('merchant.edit');
    Route::put('/merchant/restoran', [RestaurantController::class, 'update'])
        ->name('merchant.update');
});
