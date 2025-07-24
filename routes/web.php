<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// 🔒 Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;

// 👤 User
use App\Http\Controllers\User\UserHomeController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\User\UserBarangController;
use App\Http\Controllers\User\UserReportController;

// 🔐 Autentikasi
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// 🏠 Redirect root ke dashboard /home berdasarkan role
Route::redirect('/', '/admin/dashboard'); // Bisa diganti sesuai sistem redirect dinamis

// 🔐 Area Admin (role: admin only)
Route::prefix('admin')->middleware(['auth', 'cekadmin'])->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('users', UserController::class)->except(['show']);
});

// 👤 Area Pengguna (role: user)
Route::prefix('user')->middleware(['auth'])->name('user.')->group(function () {
    Route::get('home', [UserHomeController::class, 'index'])->name('home');
    Route::get('profile', [UserProfileController::class, 'index'])->name('profile');
    Route::get('barang', [UserBarangController::class, 'index'])->name('barang');
    Route::get('cek-alat', [UserReportController::class, 'create'])->name('report.create');
    Route::post('cek-alat', [UserReportController::class, 'store'])->name('report.store');
});