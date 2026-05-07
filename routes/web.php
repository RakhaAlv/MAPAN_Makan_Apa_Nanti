<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// ==========================================
// Halaman awal → redirect ke login
// ==========================================
Route::get('/', function () {
    return redirect()->route('login');
});

// ==========================================
// Auth (Register & Login) - hanya untuk tamu
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ==========================================
// USER - hanya role = user
// ==========================================
Route::middleware(['auth', 'role:user'])->group(function () {

    // Dashboard: lihat & cari restoran
    Route::get('/dashboard', [RestaurantController::class, 'index'])
        ->name('user.dashboard');

    // Detail halaman restoran
    Route::get('/restoran/{restaurant}', [RestaurantController::class, 'show'])
        ->name('restaurant.show');

    // Tambah review
    Route::post('/restoran/{restaurant}/review', [ReviewController::class, 'store'])
        ->name('reviews.store');

    // Hapus review
    Route::delete('/review/{review}', [ReviewController::class, 'destroy'])
        ->name('reviews.destroy');
});

// ==========================================
// MERCHANT - hanya role = merchant
// ==========================================
Route::middleware(['auth', 'role:merchant'])->group(function () {

    // Dashboard merchant
    Route::get('/merchant/dashboard', [RestaurantController::class, 'merchantDashboard'])
        ->name('merchant.dashboard');

    // Tambah restoran
    Route::get('/merchant/restoran/tambah',  [RestaurantController::class, 'create'])
        ->name('merchant.create');
    Route::post('/merchant/restoran',        [RestaurantController::class, 'store'])
        ->name('merchant.store');

    // Edit restoran
    Route::get('/merchant/restoran/edit',    [RestaurantController::class, 'edit'])
        ->name('merchant.edit');
    Route::put('/merchant/restoran',         [RestaurantController::class, 'update'])
        ->name('merchant.update');
});
