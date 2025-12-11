<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;

// ==========================
// AUTENTIKASI (Guest only)
// ==========================
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

// ==========================
// LOGOUT (Auth only)
// ==========================
Route::post('logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ==========================
// ROOT REDIRECT berdasarkan role
// ==========================
Route::get('/', function () {
    if (!Auth::check()) return redirect()->route('login');

    return match (Auth::user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'user'  => redirect()->route('user.home'),
        default => abort(403, 'Role tidak dikenali'),
    };
});

// ==========================
// ADMIN AREA
// ==========================
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;

Route::prefix('admin')->middleware(['auth', 'cekadmin'])->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // RUTE PRODUK ADMIN
    Route::resource('products', ProductController::class);
    // Rute BARU untuk Export CSV Produk Admin
    Route::get('products/export/csv', [ProductController::class, 'exportCsv'])->name('products.export.csv');
    
    Route::resource('categories', CategoryController::class);
    Route::resource('users', UserController::class)->except(['show']);
});

// ==========================
// USER AREA
// ==========================
use App\Http\Controllers\User\UserHomeController;
use App\Http\Controllers\User\UserProductController;
use App\Http\Controllers\User\UserBarangController;
use App\Http\Controllers\User\UserReportsController;

Route::prefix('user')->middleware(['auth', 'cekuser'])->name('user.')->group(function () {
    Route::get('home', [UserHomeController::class, 'index'])->name('home');
    
    // RUTE PRODUK USER
    Route::resource('products', UserProductController::class);
    // Rute BARU untuk Export CSV Produk User
    Route::get('products/export/csv', [UserProductController::class, 'exportCsv'])->name('products.export.csv');

    Route::get('barang', [UserBarangController::class, 'index'])->name('barang');
    Route::get('cek-alat', [UserReportsController::class, 'create'])->name('reports.create');
    Route::post('cek-alat', [UserReportsController::class, 'store'])->name('reports.store');
});

// ==========================
// PROFIL (untuk semua role login)
// ==========================
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profil/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profil/update', [ProfileController::class, 'update'])->name('profile.update');

    // Halaman Kontak (akses login saja)
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
});